<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\BaseController;
use Illuminate\Http\Request;
use App\Models\Admin\UserDetails;
use App\Base\Constants\Setting\Settings;


class PurchaseCodeController extends BaseController
{


    public function index()
    {
        $page = trans('pages_names.purchasecode');

        $main_menu = 'purchasecode';
        $sub_menu = '';

        return view('admin.purchasecode.index', compact('page', 'main_menu', 'sub_menu'));
    }
    public function verifyPurchasecode(Request $request)
    {

        $personal_token = "gSMvL9FPmVWmH3y88ZFw2WmCBCbyOcOZ";

        $purchase_code = trim($request->envato_purchase_code);

        if (!preg_match("/^([a-f0-9]{8})-(([a-f0-9]{4})-){3}([a-f0-9]{12})$/i", $purchase_code)) 
        {
            return redirect()->back()->withErrors(['envato_purchase_code'=>'Invalid Format'])->withInput();
        }

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$purchase_code}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 20,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer {$personal_token}",
                "User-Agent: Purchase code verification script"
            )
        ));

        $response = @curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
       
        $values = json_decode($response);

        if ($responseCode == 404)
        {
            return redirect()->back()->withErrors(['envato_purchase_code'=>'Please Enter Valid PurchaseCode'])->withInput();
        }elseif ($responseCode == 403 ){
            return redirect()->back()->withErrors(['envato_purchase_code'=>'Please Enter Valid PurchaseCode'])->withInput();
        }else
        {

            if(($request->envato_user_name) != ($values->buyer))
            {
             return redirect()->back()->withErrors(['envato_user_name'=>'Please Enter Valid Envato User Name'])->withInput();      
            }
                // dd($values);
                $params['user_id'] = auth()->user()->id;
                $params['country'] =+91;
                $params['name'] = $values->buyer;
                $params['token'] = $request->envato_purchase_code;
                $params['address'] = $request->ip();
                $params['state'] = request()->getHost();
// dd($params);
                // $values->sold_at;
                // $values->license;
                // $values->amount;
                // $values->purchase_count;
                UserDetails::create($params);   
                
                $message = trans('succes_messages.purchase_code_verified');
       
                return redirect('purchasecode')->with('success', $message);

        }

    }

}
