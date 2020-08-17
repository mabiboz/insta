<?php

namespace App\Http\Controllers\User;

use App\Models\News;
use App\Models\User;
use App\Models\AgentLevel;
use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $pageCount = count($user->pages);
        $campainCount = count($user->campains);
        $adCount = count($user->campains);
        
        $agentLevels = AgentLevel::where("status",1)->get();


        $lastNews = News::latest()->first();

        return view("user.dashboard.index",compact('lastNews','campainCount','pageCount',"agentLevels"));
 
    }

    public function activation(Request $request)
    {
        $this->validate($request,[
            "code" =>'required|numeric',
        ],[
            "code.required" =>'کد دریافت شده را وارد نمایید !',
            "code.numeric" =>'فرمت کد اشتباه است !',
        ]);

        $user = Auth::user();
        if($user->activation_code == $request->code){
            $user->update([
                "verify" => User::VERIFIED_AND_NOT_ACCEPT_RULE,
            ]);
            flash_message("شماره موبایل شما با موفقیت تایید گردید . شما باید برای ادامه کار ، قوانین را بپذیرید !",'success');
        }else{
            flash_message("کد وارد شده اشتباه است .",'danger');
        }
        return back();

    }

    public function acceptRules(Request $request)
    {
        $this->validate($request,[
            'accept' => 'required|accepted'
        ],[
            'accept.required' => 'ابتدا باید قوانین را بپذیرید .',
            'accept.accepted' => 'ابتدا باید قوانین را بپذیرید .',
        ]);

        Auth::user()->update([
            'verify' =>User::VERIFIED_AND_ACCEPT_RULE,
        ]);

        flash_message("تبریک ! پنل کاربری شما فعال گردید .",'success');
        return redirect()->route("user.dashboard");

    }
        public function prefactor(Request $request)
    {
        $agentLevel_id = $request->id;
        $agentLevel = AgentLevel::find($agentLevel_id);
        if(!$agentLevel){
            exit;
        }
        $html = view("user.dashboard.sections.prefactor",compact("agentLevel"))->render();
        return response($html);
    }
    
        public function payment(AgentLevel $agentLevel)
    {
        $amount = $agentLevel->price -  Auth::user()->wallet->sum ;
        try {
            $bank = getBankName();

            $gateway = \Gateway::{$bank}();

            $gateway = \Gateway::setCallback(route('user.dashboard.agentRequest.payback',$agentLevel));

            $gateway->price($amount*10)->ready();


            return $gateway->redirect();
        } catch (\Exception $e) {

            flash_message("شروع روند پرداخت با مشکل مواجه شد.", "danger");
            return back();
        }
    }

    function payback(Request $request,AgentLevel $agentLevel)
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



                $request->request->add(["agentLevel"=>$agentLevel->id]);
                ( new RequestConvertAgentController())->requestConvertToAgent($request);

            }
            flash_message('پنل نمایندگی با موفقیت  درخواست داده شد !','success');
            return redirect()->route('user.dashboard');

        } catch (\Exception $e) {
            flash_message("پرداخت انجام نشد.", "danger");
            //flash_message($e, "danger");
            return redirect()->route('user.dashboard');
        }
    }
}
