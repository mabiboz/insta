<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfitController extends Controller
{
    public function all()
    {
     
        $profits=Profit::query();
         $profits = searchItems(['page.name','page.instapage_id','ad.content'],$profits);
       $profits =  $profits->latest()->paginate(25);

        $incom=Profit::all()->sum('amount');
        return view('admin.profit.all',compact('profits','incom'));
    }
}
