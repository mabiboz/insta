<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use App\Models\Adstatistics;
use App\Models\Campain;
use App\Models\PageRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserCamapinsController extends Controller
{
    public function index()
    {

        $campains = Campain::whereHas("user",function ($query){
            $query->where("role","!=",User::ROLE_MABINO);
        })->get();

        return view("admin.userCampain.index", compact("campains"));
    }
    public function getDescription($id)
    {
        $campain = Campain::find($id);
        $ad = $campain->ads->first();
        if(!$ad){
            return "آگهی حذف شده است !";
        }

        return view("admin.userCampain.sections.ajaxForDetailAdCampain", compact("ad"));

    }

    public function getCampainPagesAjax(Request $request)
    {


        $campain = Campain::find($id);

        $pages = $campain->pages;
        $ad = $campain->ads()->first();

        foreach ($pages as $page) {
            $pageRequest = PageRequest::where('ad_id', $ad->id)->where('page_id', $page->id)->first();
            $adstatiscit=Adstatistics::where('pagerequest_id',$pageRequest->id)->first();
            if(isset($adstatiscit)){
                $page->pageRequestStatus = $pageRequest->status;
                $page->like=$adstatiscit->likecount;
                $page->comment=$adstatiscit->commentcount;
                $page->view=$adstatiscit->viewcount;
                $page->followers=$adstatiscit->followers;
                $page->endshow=$adstatiscit->endshow;
                $page->end_work=$adstatiscit->end_work;

            }else{
                $page->pageRequestStatus = $pageRequest->status;
                $page->pageRequestLink = $pageRequest->link;
                $page->like=0;
                $page->comment=0;
                $page->view=0;
                $page->followers=0;
                $page->end_work=0;
            }

        }

        $html =  view("admin.userCampain.sections.ajaxViewForPageListAndDetails", compact("pages","ad"))->render();
        return response($html);

    }




    public function PlanBAdlistAndCheckout(Campain $campain)
    {

        $pages = $campain->pages()->where("plan","b")->get();
        $ad = $campain->ads()->first();

        $pageRequests =[];
        foreach ($pages as $page) {
            $item = PageRequest::where('ad_id', $ad->id)->where('page_id', $page->id)->where("status",PageRequest::ACCEPTED)->first();
            if(!is_null($item)){
                $pageRequests[] =$item ;
            }
        }

        return view("admin.adsPlanB.index",compact("pageRequests"));


    }
}
