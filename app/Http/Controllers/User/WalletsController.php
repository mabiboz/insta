<?php

namespace App\Http\Controllers\User;

use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WalletsController extends Controller
{


    function pay(Request $request)
    {
        $this->validate($request,[
            'amount'=>'required | numeric | min:10'
        ],[
            'amount.required' =>'وارد کردن مبلغ شارژ الزامی می باشد .',
            'amount.numeric' =>'مقدار واردشده نامعتبر است .',
            'amount.min' =>'حداقل مقدار شارژ باید 1000 تومان باشد .',
        ]);
        $amount = $request->input('amount');

        try {
            $bank = getBankName();
          
            $gateway = \Gateway::{$bank}();
           
            $gateway = \Gateway::setCallback(route('user.wallet.charge.payback'));
            
            $gateway->price($amount)->ready();
          
    
            return $gateway->redirect();
        } catch (\Exception $e) {
          
            flash_message("شروع روند پرداخت با مشکل مواجه شد.", "danger");
            return back();
        }
    }

    function payback(Request $request)
    {


        try {
            $gateway = \Gateway::verify();

            $trackingCode = $gateway->trackingCode();
            $refId =$gateway->refId();
            $cardNumber = $gateway->cardNumber();



            if($gateway){
                $transaction_id = $request->transaction_id;

                $gateway_transaction = \DB::table('gateway_transactions')->find($transaction_id);
                $transaction_price=$gateway_transaction->price;
                if($gateway_transaction->port != "ZARINPAL" ){
                    $transaction_price = $transaction_price/10;
                }


                $user = Auth::user();

                $wallet = Wallet::where('user_id',$user->id)->first();
                $sum = $wallet->sum + $transaction_price;
                $wallet->update(['sum'=>$sum]);

                WalletLog::create([
                    'user_id'=>$user->id,
                    'transaction_id'=>$transaction_id,
                    'price' => $transaction_price,
                    'method_create' => WalletLog::ONLINE,
                    'wallet_operation' =>WalletLog::INCREMENT,
                ]);


            }
            flash_message('شارژ کیف پول با موفقیت انجام شد.','success');
            return redirect()->route('user.dashboard');

        } catch (\Exception $e) {
            flash_message("پرداخت انجام نشد.", "danger");
            //flash_message($e, "danger");
            return redirect()->route('user.dashboard');
        }
    }


}
