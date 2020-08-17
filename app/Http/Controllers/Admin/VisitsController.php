<?php

namespace App\Http\Controllers\Admin;

use App\Models\IP;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VisitsController extends Controller
{
    public function index()
    {
        $today = Carbon::now();
        $today = $today->setTime("0", "0", "0");


        $visitCount = IP::whereDate('created_at', Carbon::today())->get()->groupBy('address')->count();
        $visitCountYesterday = IP::whereDate('created_at', Carbon::yesterday())->get()->groupBy('address')->count();

        $visitChart=[];
        for ($i = 1; $i <= 7; $i++) {
            $startDate = Carbon::now()->subDays($i)->setTime("0","0","0");
			
		
            $endDate = Carbon::now()->subDays($i)->setTime("23","59","59");

	
			
            $visitChart[] = IP::where('created_at',">=", $startDate)->where('created_at',"<=", $endDate)->get()->groupBy('address')->count();
				

        }
	


$ips = IP::whereDate('created_at', Carbon::today())->get()->groupBy("address");









        $visitChart = array_reverse($visitChart);


    //   $deleteIp = IP::whereDate('created_at',"<", Carbon::now()->subMonth(1))->get()->pluck('id')->toArray();
    //     IP::destroy($deleteIp);

	

        return view("admin.visit.index", compact("visitCount", "visitCountYesterday","visitChart","cityArrayIp"));
    }




}
