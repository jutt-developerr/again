<?php

namespace App\Http\Controllers\Api\V1\Payment\Khalti;

use App\Base\Constants\Auth\Role;
use App\Base\Constants\Masters\PushEnums;
use App\Base\Constants\Masters\WalletRemarks;
use App\Base\Constants\Setting\Settings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\AddMoneyToWalletRequest;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Models\Payment\DriverWallet;
use App\Models\Payment\DriverWalletHistory;
use App\Models\Payment\OwnerWallet;
use App\Models\Payment\OwnerWalletHistory;
use App\Models\Payment\UserWallet;
use App\Models\Payment\UserWalletHistory;
use App\Transformers\Payment\DriverWalletTransformer;
use App\Transformers\Payment\OwnerWalletTransformer;
use App\Transformers\Payment\WalletTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Jobs\Notifications\SendPushNotification;

class KhaltiController extends Controller
{
    public function addMoneyToWallet(AddMoneyToWalletRequest $request)
    {

        $transaction_id = $request->payment_id;
        $user = auth()->user();

        if (access()->hasRole('user')) {
            $wallet_model = new UserWallet();
            $wallet_add_history_model = new UserWalletHistory();
            $user_id = auth()->user()->id;
        } elseif($user->hasRole('driver')) {
            $wallet_model = new DriverWallet();
            $wallet_add_history_model = new DriverWalletHistory();
            $user_id = $user->driver->id;
        }else {
            $wallet_model = new OwnerWallet();
            $wallet_add_history_model = new OwnerWalletHistory();
            $user_id = $user->owner->id;
        }

        $user_wallet = $wallet_model::firstOrCreate([
            'user_id'=>$user_id]);
        $user_wallet->amount_added += $request->amount;
        $user_wallet->amount_balance += $request->amount;
        $user_wallet->save();
        $user_wallet->fresh();

        $wallet_add_history_model::create([
            'user_id'=>$user_id,
            'amount'=>$request->amount,
            'transaction_id'=>$transaction_id,
            'remarks'=>WalletRemarks::MONEY_DEPOSITED_TO_E_WALLET,
            'is_credit'=>true]);


        $pus_request_detail = json_encode($request->all());

        $socket_data = new \stdClass();
        $socket_data->success = true;
        $socket_data->success_message  = PushEnums::AMOUNT_CREDITED;
        $socket_data->result = $request->all();

        $title = trans('push_notifications.amount_credited_to_your_wallet_title',[],$user->lang);
        $body = trans('push_notifications.amount_credited_to_your_wallet_body',[],$user->lang);

        // dispatch(new NotifyViaMqtt('add_money_to_wallet_status'.$user_id, json_encode($socket_data), $user_id));

        dispatch(new SendPushNotification($user,$title,$body));

        if (access()->hasRole(Role::USER)) {
            $result =  fractal($user_wallet, new WalletTransformer);
        } elseif(access()->hasRole(Role::DRIVER)) {
            $result =  fractal($user_wallet, new DriverWalletTransformer);
        }else{
            $result =  fractal($user_wallet, new OwnerWalletTransformer);

        }

        return $this->respondSuccess($result, 'money_added_successfully');
    }

}
