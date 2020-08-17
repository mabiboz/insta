<?php

namespace App\Http\Controllers\user;

use App\Models\PayRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PayRequestController extends Controller
{
    public function PayRequest(Request $request)
    {
        
         $this->validate($request,[
           'amount'=>'required|numeric|min:500000'
        ],[
            'amount.required'=>'مبلغ الزامی می باشد !',
            'amount.numeric'=>'فرمت مبلغ وارد شده صحیح نمی باشد !',
            'amount.min'=>'حداقل مبلغ برای درخواست وجه 50 هزارتومان می باشد !',

        ]);
        
        $amount=$request->amount/10;
        $user=Auth::user();
        $user_id=$user->id;
        $wallet_sum=$user->wallet->sum;
        $pending_request=$user->payRequests()->where('status',PayRequest::PENDING)->get();
        $pending_request_sum=0;
        foreach ($pending_request as $pending){
            $pending_request_sum+=$pending->amount;
        }

       if($amount>$wallet_sum){
           flash_message('مقدار مبلغ درخواستی از موجودی کیف پول شما بیشتر است!','danger');
           return back();

       }
        if($amount+$pending_request_sum>$wallet_sum){
            flash_message('مجموع مبلغ درخواستی با مبالغ درخواستی تسویه نشده شما بیشتر از موجودی کیف پول شما است!','danger');
            return back();

        }
       PayRequest::create([
           'user_id'=>$user_id,
           'amount'=>$amount,
           'status'=>PayRequest::PENDING,
       ]);

        flash_message('درخواست شما با موفقیت ارسال شد','success');
        return back();


    }


    public function all()
    {
        $payrequests=Auth::user()->payRequests;
        return view('user.payRequest.all',compact('payrequests'));
    }

    public function pending()
    {
        $payrequests=Auth::user()->payRequests->where('status',0);
        return view('user.payRequest.all',compact('payrequests'));
    }
}
