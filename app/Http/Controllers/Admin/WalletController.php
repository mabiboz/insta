<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    //
    public function showchargeform($id)
    {
        $user=User::find($id);
        if($user){
            return view('admin.users.sections.walletcharge',compact('user'));
        }

    }

    public function charge(Request $request)
    {
        $user = User::find($request->user_id);

        $wallet = Wallet::where('user_id',$user->id)->first();
        $sum = $wallet->sum + $request->amount/10;
        $wallet->update(['sum'=>$sum]);

        WalletLog::create([
            'user_id'=>$user->id,
            'transaction_id'=>0,
            'price' => $request->amount/10,
            'description' =>$request->description,
            'method_create' => WalletLog::TASHVIGHI,
            'wallet_operation' =>WalletLog::INCREMENT,
        ]);
        flash_message('شارژ کیف پول با موفقیت انجام شد.','success');
        return redirect()->back();
    }
}
