<?php

namespace App\Http\Controllers\Admin;

use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MabinoWalletController extends Controller
{
    public function mabinoWalletLog()
    {
        $walletLogs = Auth::user()->walletlogs()->latest()->get();
        $walletOperations = WalletLog::getWalletOperation();
        $methodsCreateWallet = WalletLog::getMethodWalletCreate();
        return view("admin.mabinoWalletLog.index",compact("walletLogs","walletOperations","methodsCreateWallet"));
    }

    public function mabinoWalletCharge(Request $request)
    {
        $amount = $request->amount;
        Auth::user()->wallet->update([
            "sum" => Auth::user()->wallet->sum + $amount/10,
        ]);
        WalletLog::create([
            'user_id'=>Auth::user()->id,
            'price' => $amount,
            'method_create' => WalletLog::TASHVIGHI,
            'wallet_operation' =>WalletLog::INCREMENT,
        ]);

        flash_message("با موفقیت شارژ شد !","success");
        return back();
    }
}
