<?php

namespace App\Http\Controllers\User;

use App\Models\Ad;
use App\Models\PageRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PlanBAdsController extends Controller
{
    public function index()
    {
        $pages = Auth::user()->plan_b_pages;
        $adsArray = [];
        foreach ($pages as $page) {
            foreach ($page->pageRequest as $pageRequest) {
                if ($pageRequest->ad->status == Ad::OK) {
                    if ($pageRequest->status == PageRequest::PENDING and $pageRequest->ad->expired_at->greaterThan(Carbon::now())) {
                        $adsArray[$page->id][] = $pageRequest->ad;
                    } elseif ($pageRequest->status == PageRequest::ACCEPTED ) {
                        $adsArray[$page->id][] = $pageRequest->ad;
                    }
                }


            }
        }


        return view("user.newAdPlanB.list", compact("adsArray"));
    }

    public function registerLink(Request $request)
    {
        $this->validate($request,[
            "page_id"=>"required",
            "ad_id"=>"required",
            "link"=>"required",
        ],[
            "link.required"=>"لینک آگهی الزامی می باشد !",
        ]);
        $ad_id = $request->ad_id;
        $page_id = $request->page_id;

        $pageRequest = PageRequest::where("page_id",$page_id)->where("ad_id",$ad_id)->latest()->first();
        if($pageRequest->status != PageRequest::ACCEPTED){
            flash_message("برای ثبت لینک ، باید ابتدا آگهی را انتشار دهید !","danger");
            return back();
        }

        $pageRequest->update([
            "link" => $request->link,
        ]);
        flash_message("لینک آگهی با موفقیت ثبت شد !","success");
        return back();

    }
}
