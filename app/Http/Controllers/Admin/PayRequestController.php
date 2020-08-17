<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\PayRequest;
use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PayRequestController extends Controller
{


    public function all()
    {
        $payrequests=PayRequest::query();
        $payrequests = searchItems(['user.name','user.mobile'],$payrequests);
        $payrequests = $payrequests->latest()->paginate(15);

        return view('admin.payRequest.all',compact('payrequests'));
    }

    public function pending()
    {
        $payrequests=PayRequest::where('status',0);
        $payrequests = searchItems(['user.name','user.mobile'],$payrequests);
        $payrequests = $payrequests->latest()->paginate(15);
        return view('admin.payRequest.pending',compact('payrequests'));
    }

    public function pay(Request $request)
    {
        $id=$request->id;
        $status=PayRequest::find($id)->status;
        $payreq=PayRequest::find($id);
        if($status==0){
            $payrequest= PayRequest::find($id)->update(['status' => PayRequest::SUCCESS]);
            if($payrequest){

                $payreq->user->wallet->update([
                    'sum'=>$payreq->user->wallet->sum-$payreq->amount
                ]);

                WalletLog::create([
                    'user_id'=>$payreq->user->id,
                    'transaction_id'=>0,
                    'price' => $payreq->amount,
                    'method_create' => WalletLog::MABINO,
                    'wallet_operation' =>WalletLog::DECREMENT,
                ]);

                return 'active';

            }
            return 'error';
        }else{
            $payrequest= PayRequest::find($id)->update(['status' => PayRequest::PENDING]);
            if($payrequest){
                return 'inactive';

            }
            return 'error';
        }

    }
}
