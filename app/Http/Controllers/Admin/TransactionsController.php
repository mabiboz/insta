<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    public function all()
    {
        $transactions = DB::table('gateway_transactions')->where("status","SUCCEED");
        $transactions = searchItems(['tracking_code'],$transactions);
        $transactions = $transactions->latest()->paginate(100);
        return view("admin.transaction.all",compact("transactions"));
    }
}
