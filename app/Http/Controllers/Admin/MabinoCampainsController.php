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

class MabinoCampainsController extends Controller
{
    public function index()
    {

        $mabinoUsers = User::where("role",User::ROLE_MABINO)->pluck("id")->toArray();
        $ads = Ad::whereIn("user_id",$mabinoUsers)->get();

        $resultCampain = [];
        foreach ($ads as $ad){
            $resultCampain[$ad->id] = $ad->campains->groupBy(function($campain){
               return Carbon::parse($campain->created_at)->format('Y-m-d');
            });
        }
        return view("admin.mabinoCampain.index", compact("resultCampain"));
    }
    public function getDescription($id)
    {
        $campain = Campain::find($id);
        $ad = $campain->ads->first();
        if(!$ad){
            return "آگهی حذف شده است !";
        }

        return view("admin.mabinoCampain.sections.ajaxForDetailAdCampain", compact("ad"));

    }

    public function getCampainPagesAjax(Request $request)
    {

        $dataString  = $request->id;
        list($ad_id,$campain_created_at) = explode("*",$dataString);
        $ad = Ad::find($ad_id);

         $campains =$ad->campains
             ->where("created_at",">=",Carbon::parse($campain_created_at)->startOfDay())
             ->where("created_at","<=",Carbon::parse($campain_created_at)->endOfDay());


         $pages=[];

         foreach ($campains as $campain){
             $item=$campain->pages()->first();
             if(!is_null($item)){
                 $pages[$campain->id] = $item;
             }
         }


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
                    $page->pageRequestStatus = 0;
                    $page->like=0;
                    $page->comment=0;
                    $page->view=0;
                    $page->followers=0;
                    $page->end_work=0;
                }



        }

        $html =  view("admin.mabinoCampain.sections.ajaxViewForPageListAndDetails", compact("pages","ad"))->render();
        return response($html);

    }


    public function PlanBAdlistAndCheckout(Ad $ad,$date)
    {

        $campain_created_at = $date;
        $campains =$ad->campains
            ->where("created_at",">=",Carbon::parse($campain_created_at)->startOfDay())
            ->where("created_at","<=",Carbon::parse($campain_created_at)->endOfDay());


        $pages=[];
        foreach ($campains as $campain){
            $item = $campain->pages()->where("plan","b")->first();
            if(!is_null($item)){
                $pages[$campain->id] = $item;
            }
        }


        $pageRequests = [];
        foreach ($pages as $page) {
            $item = PageRequest::where('ad_id', $ad->id)->where('page_id', $page->id)->where("status",PageRequest::ACCEPTED)->first();
            if(!is_null($item)){
                $pageRequests[] =$item ;
            }

        }

        return view("admin.adsPlanB.index",compact("pageRequests"));


    }

}
