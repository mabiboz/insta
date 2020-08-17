<?php

namespace App\Http\Controllers\User;

use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WalletLogsController extends Controller
{
    public function index()
    {
        $walletLogs = Auth::user()->walletlogs()->latest()->get();
        $walletOperations = WalletLog::getWalletOperation();
        $methodsCreateWallet = WalletLog::getMethodWalletCreate();
        return view("user.walletlogs.index",compact("walletLogs","walletOperations","methodsCreateWallet"));
    }
    
    public function getDescription(Request $request)
    {
        $walletLog_id = $request->id;
        $walletLog = WalletLog::find($walletLog_id);
        if(!$walletLog){
            exit;
        }
        return response($walletLog->description);
    }
}
