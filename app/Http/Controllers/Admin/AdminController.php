<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use App\Models\Page;
use App\Models\Profit;
use App\Models\User;
use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $userCount=User::where('role',User::ROLE_USER)->get()->count();
        $pageOwnerCount=User::where('role',User::ROLE_USER)->where('is_admin',1)->get()->count();
        $pageCount=Page::all()->count();
        $adCount=Ad::all()->count();
        $incom=Profit::all()->sum('amount');

        return view('admin.dashboard.index',compact('userCount','pageCount','adCount','incom','pageOwnerCount'));
    }
    
   
}
