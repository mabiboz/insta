<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ProfitSharing;
use App\Models\Ad;
use App\Models\Page;
use App\Models\PageRequest;
use Carbon\Carbon;
use App\Models\Adstatistics;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanBAdsController extends Controller
{
    public function list()
    {
        $pageRequests= PageRequest::where("status",PageRequest::ACCEPTED)->whereHas("page",function ($q){
            $q->where("plan","b");
        })->latest()->get();
        return view("admin.adsPlanB.index",compact("pageRequests"));

    }

    public function checkout(Ad $ad,Page $page)
    {
        $pageRequest = PageRequest::where("page_id",$page->id)->where("ad_id",$ad->id)->latest()->first();
        $pageRequest->update([
            "status" => PageRequest::FINISHED,
        ]);
        $profitSharing = new ProfitSharing($page,$ad);

        $profitSharing->forPageOwner();
        $profitSharing->forReagent();
        flash_message("تسویه با موفقیت انجام شد !","success");
        return back();
    }


    public function statisticsEdit(Request $request)
    {
        $pageRequest_id = $request->id;
        $pageRequest = PageRequest::find($pageRequest_id);

        $statistic = $pageRequest->statistics;

        if(!$statistic){
            return "آمار وجود ندارد !";
        }

        $html = view("admin.adsPlanB.sections.statisticForm",compact("statistic","pageRequest"))->render();
        return response()->json($html);

    }
    public function statisticsUpdate(Request $request)
    {
        $statistic =   Adstatistics::find($request->statistic);

        if($statistic){
            $statistic->update([
                'endshow'=>Carbon::now(),
                'end_work' => 1,
                'followers'=>$request->followers,
                'viewcount' =>$request->viewcount,
                'commentcount' =>$request->commentcount,
                'likecount' =>$request->likecount,
            ]);

            $statistic->pagerequest->update([
                "link" => $request->input('link')
            ]);
        }
        flash_message(" با موفقیت انجام شد !","success");
        return back();
    }

    public function checkouted()
    {
        $pageRequests= PageRequest::where("status",PageRequest::FINISHED)->whereHas("page",function ($q){
            $q->where("plan","b");
        })->latest()->get();
        return view("admin.adsPlanB.checkoutedList",compact("pageRequests"));

    }
}
