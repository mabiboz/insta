<?php

namespace App\Http\Controllers\Admin;

use App\Events\newAdForPage;
use App\Http\Controllers\User\AdsController;
use App\Models\Ad;
use App\Models\ReasonAbort;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class AdController extends Controller
{
    //
    public function notVerified()
    {

        $ads = Ad::where('status', Ad::PENDING);
        $ads = searchItems(['content','campains.title',],$ads);
        $ads = $ads->latest()->paginate(15);
        return view('admin.ads.notverified', compact('ads'));
    }

    public function changestate(Request $request)
    {
        $newStatus = $request->newStatus;
        $adid = $request->id;
        

         


        if ($newStatus == 2) {
            $ad = Ad::find($adid);
            $ad->update(['status' => Ad::OK]);
           
           acceptcampain($ad->campains()->first()->user->name,$ad->campains()->first()->user->mobile);

            $campain  = $ad->campains()->first();
            $pages = $campain->pages;
            foreach ($pages as $page){
                getad($page->user->name,$page->user->mobile);

                 if($page->user->autosend){
                    /* check username and password is correct*/

                    $exceptions  =null;
                    try{
                        $debug = false;
                        $truncatedDebug = false;

                        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
                        $ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
                        $username = $page->pagedetail->username;
                        $password = $page->pagedetail->password;
                        $ig->login($username, $password);
                        $ig->isMaybeLoggedIn;
                    }catch(\Exception $e){
                        $exceptions = $e;
                    }

                    /*end check username and password is correct*/


                    if(is_null($exceptions)){
                        $request->request->add(["state"=>2,"id"=>$ad->id,"pageid"=>$page->id]);
                        $newAutoSend = new AdsController();
                        $newAutoSend->changeState($request);
                        
                    }
                    
                    
                
                }

            }
            
            event(new newAdForPage($ad));
            $reasonAbort = $ad->reasonAbort;
            if($reasonAbort){
                $reasonAbort->update([
                    "status" =>ReasonAbort::VERIFIED,
                ]);
            }

        } else{
            $ad = Ad::find($adid);
            $ad->update(['status' => Ad::FAILED]);
            $ad_reason_abort = $ad->reasonAbort;
            if($ad_reason_abort){
                $ad_reason_abort->update([
                    "status" =>ReasonAbort::ABORT,
                    "content" => $request->reason_content,
                ]);
            }else{
                ReasonAbort::create([
                    "ad_id" => $adid,
                    "content" => $request->reason_content,
                    "status" =>ReasonAbort::ABORT,
                ]);
            }

        }


    }

    public function adlist()
    {
        $ads = Ad::query();
        $ads = searchItems(['content','campains.title',],$ads);
        $ads = $ads->latest()->paginate(15);
        return view('admin.ads.all', compact('ads'));

    }
    
    
    public function delete(Ad $ad)
    {
        $result = $ad->delete();
        if($result){
            flash_message("با موفقیت حذف شد !",'success');
        }else{
            flash_message("مشکلی رخ داده !",'danger');
        }
        
        return back();
    }
}
