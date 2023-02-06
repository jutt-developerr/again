<?php

namespace App\Http\Controllers\Api\V1\Payment\Kashier;

use App\Base\Constants\Masters\PushEnums;
use App\Base\Constants\Masters\WalletRemarks;
use App\Base\Constants\Setting\Settings;
use App\Http\Controllers\Controller;
use App\Jobs\Notifications\AndroidPushNotification;
use App\Models\Payment\DriverWallet;
use App\Models\Payment\DriverWalletHistory;
use App\Models\Payment\OwnerWallet;
use App\Models\Payment\OwnerWalletHistory;
use App\Models\Payment\UserWallet;
use App\Models\Payment\UserWalletHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Jobs\Notifications\SendPushNotification;

class KashierController extends Controller
{
    /**
     * Initialize Payment
     *
     *
     *
     * */
    public function initialize(Request $request)
    {
        $mid = "MID-8448-188"; //your merchant id
        $amount = $request->amount; //eg: 100
        $currency = $request->currency; //eg: "EGP"
        $reference = auth()->user()->id;
        $current_timestamp = Carbon::now()->timestamp;
        $orderId = $current_timestamp . '-' . $reference;//eg: 99, your system order ID
        if (get_settings(Settings::KASHIER_ENVIRONMENT) == 'test')
        {
            $mode='test';
            $secret = get_settings(Settings::KASHIER_TEST_SECRET_KEY);
        }
        else
        {
            $mode='live';
            $secret = get_settings(Settings::KASHIER_PRODUCTION_SECRET_KEY);
        }
        $path = "/?payment=" . $mid . "." . $orderId . "." . $amount . "." . $currency;
        $hash = hash_hmac('sha256', $path, $secret, false);
        $url='https://checkout.kashier.io/?merchantId='.$mid.'&orderId='.$orderId.'&amount='.$amount.'&currency='.$currency.'&hash='.$hash.'&mode='.$mode.'&serverWebhook=https:%2F%2Fadmin.soonereg.com%2Fapi%2Fv1%2Fpayment%2Fkashier%2Fweb-hook&type=external&display=en';
        if ($hash) {
            return response()->json([
                'success' => 'transaction initialized',
                'merchantId' => $mid,
                'mode'=>$mode,
                'secret'=>$secret,
                'hash' => $hash,
                'currency' => $currency,
                'amount' => $amount,
                'orderId' => $orderId,
                'url'=>$url]);
        }

    }

    /**
     * Webhook Payment
     *
     *
     *
     * */

    public function webhook(Request $request)
    {
        $response = $request->all();
        Log::info($response);
        $transaction_id = $request->data['transactionId'];
        $requested_amount = $request->data['amount'];
        $currency = $request->data['currency'];
        $explode_kashier_order_id = explode('-', $request->data['merchantOrderId']);
        $user_id = $explode_kashier_order_id[1];
        $user = User::find($user_id);

        if ($user->hasRole('user')) {
            Log::info('user-role');
            $wallet_model = new UserWallet();
            $wallet_add_history_model = new UserWalletHistory();
        } elseif ($user->hasRole('driver')) {
            $wallet_model = new DriverWallet();

            Log::info('driver-role');

            $wallet_add_history_model = new DriverWalletHistory();
            $user_id = $user->driver->id;
        } else {

            Log::info('owner-role');

            $wallet_model = new OwnerWallet();
            $wallet_add_history_model = new OwnerWalletHistory();
            $user_id = $user->owner->id;
        }

        $user_wallet = $wallet_model::firstOrCreate([
            'user_id' => $user_id]);
        $user_wallet->amount_added += $requested_amount;
        $user_wallet->amount_balance += $requested_amount;
        $user_wallet->save();
        $user_wallet->fresh();

        $wallet_add_history_model::create([
            'user_id' => $user_id,
            'amount' => $requested_amount,
            'transaction_id' => $transaction_id,
            'remarks' => WalletRemarks::MONEY_DEPOSITED_TO_E_WALLET,
            'is_credit' => true]);


        $pus_request_detail = json_encode($request->all());

        $socket_data = new \stdClass();
        $socket_data->success = true;
        $socket_data->success_message = PushEnums::AMOUNT_CREDITED;
        $socket_data->result = $request->all();

        $title = trans('push_notifications.amount_credited_to_your_wallet_title', [], $user->lang);
        $body = trans('push_notifications.amount_credited_to_your_wallet_body', [], $user->lang);

        // dispatch(new NotifyViaMqtt('add_money_to_wallet_status'.$user_id, json_encode($socket_data), $user_id));

        dispatch(new SendPushNotification($user,$title,$body));

        $result = $this->respondSuccess(null, 'money_added_successfully');

    }
}

