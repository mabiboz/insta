<?php

namespace App\Http\Controllers\User;

use App\Helper\ProfitSharing;
use App\customclass\postToInstagram;
use App\Jobs\SendPostToInstagram;
use App\Models\Ad;
use App\Models\Page;
use App\Models\PageRequest;
use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Models\Profit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{


    public function myAds()
    {
        $user = Auth::user();
        $pages  = $user->pages;
        $pageRequests= [];
        foreach ($pages as $page){
            $pageRequests[] = $page->pageRequest()->whereIn("status",[PageRequest::ACCEPTED,PageRequest::FINISHED])->get();
        }
        return view("user.ads.myAds",compact("pageRequests"));
        
    }
    
    public function changeState_old(Request $request)
    {

        $state = $request->state;
        $ad_id = $request->id;
        $page_id = $request->pageid;
        $ad = Ad::find($ad_id);
        $page = Page::find($page_id);
        if (!$ad or !$page) {
            abort(404);
        }
        if(!isset($page->pagedetail)){
            flash_message("برای پذیرش آگهی،ابتدا نام کاربری و رمز عبور پیج خود را در سامانه وارد نمایید!", 'warning');
            return 'notFoundDetail';
        }
        if ($state == 2) {
            $newState = PageRequest::ACCEPTED;
        } elseif ($state == 0) {
            $newState = PageRequest::FAILED;
        } elseif ($state == 3) {
            $newState = PageRequest::FINISHED;
        } else {
            exit;
        }

        $pageRequest = PageRequest::where("page_id", $page_id)->where("ad_id", $ad_id)->first();
        $result = $pageRequest->update([
            "status" => $newState,
        ]);
        if (!$result) {
            exit;
        }

        $ownerAd = $ad->campain->user;
        $price = $page->price * getRatio($ad->day_count);

        if ($pageRequest->status == PageRequest::FAILED) {

            $ownerAd->wallet->update([
                "sum" => $ownerAd->wallet->sum + $price,
            ]);


            WalletLog::create([
                'user_id' => $ownerAd->id,
                'price' => $price,
                'method_create' => WalletLog::ABORT_AD,
                'wallet_operation' => WalletLog::INCREMENT,
            ]);
        }elseif ($pageRequest->status == PageRequest::ACCEPTED) {

            $this->dispatch(new SendPostToInstagram($pageRequest,$price,$ad,$page));

        }


        flash_message("عملیات با موفقیت انجام شد ! ", 'success');


    }


   public function changeStatenewold(Request $request)
    {
        
       
        $state = $request->state;
        $ad_id = $request->id;
        $page_id = $request->pageid;
        $ad = Ad::find($ad_id);
        $page = Page::find($page_id);
       //dd($page);
        if (!$ad or !$page) {
           
            exit;
        }
        if(!isset($page->pagedetail)){
            flash_message("برای پذیرش آگهی،ابتدا نام کاربری و رمز عبور پیج خود را در سامانه وارد نمایید!", 'warning');
            return 'notFoundDetail';
        }
        if ($state == 2) {
            $newState = PageRequest::ACCEPTED;
        } elseif ($state == 0) {
            $newState = PageRequest::FAILED;
        } elseif ($state == 3) {
            $newState = PageRequest::FINISHED;
        } else {
            exit;
        }

        $pageRequest = PageRequest::where("page_id", $page_id)->where("ad_id", $ad_id)->first();
        $ownerAd = $ad->campain->user;
        $price = $page->price * getRatio($ad->day_count);


        if ($newState == PageRequest::FAILED) {

            $ownerAd->wallet->update([
                "sum" => $ownerAd->wallet->sum + $price,
            ]);


            WalletLog::create([
                'user_id' => $ownerAd->id,
                'price' => $price,
                'method_create' => WalletLog::ABORT_AD,
                'wallet_operation' => WalletLog::INCREMENT,
            ]);
        }elseif ($newState == PageRequest::ACCEPTED) {
            

            /*check username and password is correct*/
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
                //dd($e);
              $exceptions = $e;
              
            }

            /*end check username and password is correct*/

            //  $username = $page->pagedetail->username;
            //     $password = $page->pagedetail->password;
            // $newAttemp=new postToInstagram();
       
     // $loginResult = $newAttemp->checkLogin($username, $password);

       // if(!isset($loginResult['invalid_credentials'])){
 
    if(is_null($exceptions)){
              $this->dispatch(new SendPostToInstagram($pageRequest,$price,$ad,$page));
                 $pageRequest->update([
                    "status" => $newState,
                ]);

            }else{
              
                flash_message("نام کاربری یا کلمه عبور پیج شما اشتباه می باشد !","danger");
                return 'inCorrectDetail';
            }

        }



        flash_message("عملیات با موفقیت انجام شد ! ", 'success');


    }

 public function changeState(Request $request)
    {
        
       
        $state = $request->state;
        $ad_id = $request->id;
        $page_id = $request->pageid;
        $ad = Ad::find($ad_id);
        $page = Page::find($page_id);
       
        if (!$ad or !$page) {
            exit;
        }
        if($page->plan == "a"){
            if(!isset($page->pagedetail)){
                flash_message("برای پذیرش آگهی،ابتدا نام کاربری و رمز عبور پیج خود را در سامانه وارد نمایید!", 'warning');
                return 'notFoundDetail';
            }
        }

        if ($state == 2) {
            $newState = PageRequest::ACCEPTED;
        } elseif ($state == 0) {
            $newState = PageRequest::FAILED;
        } elseif ($state == 3) {
            $newState = PageRequest::FINISHED;
        } else {
            exit;
        }

        $pageRequest = PageRequest::where("page_id", $page_id)->where("ad_id", $ad_id)->first();
        $ownerAd = $ad->campain->user;
        $price = $page->price * getRatio($ad->day_count);


        if ($newState == PageRequest::FAILED) {
           

            $ownerAd->wallet->update([
                "sum" => $ownerAd->wallet->sum + $price,
            ]);


            WalletLog::create([
                'user_id' => $ownerAd->id,
                'price' => $price,
                'method_create' => WalletLog::ABORT_AD,
                'wallet_operation' => WalletLog::INCREMENT,
            ]);
             $pageRequest->update([
                    "status" => $newState,
                ]);
        }elseif ($newState == PageRequest::ACCEPTED) {
            if($page->plan == "a"){
                /*check username and password is correct*/
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

                if(is_null($exceptions)){
                    $this->dispatch(new SendPostToInstagram($pageRequest,$price,$ad,$page));
                    // dd($pageRequest,$newState);
                    $pageRequest->update([
                        "status" => $newState,
                    ]);

                }else{
//dd($exceptions);
                    flash_message("نام کاربری یا کلمه عبور پیج شما اشتباه می باشد !","danger");
                    return 'inCorrectDetail';
                }

            }else{
                //plan b
                $pageRequest->update([
                    "status" => $newState,
                ]);
                 $profitForMabino = new ProfitSharing($page,$ad);
                $profitForMabino->forMabino();



            }

        }
        
        flash_message("عملیات با موفقیت انجام شد ! ", 'success');


    }



    public function showDetails(Request $request)
    {
        $ad_id = $request->id;
        $page_id = $request->pageid;
        $ad = Ad::find($ad_id);
        $page = Page::find($page_id);
        if (!$ad or !$page) {
            exit;
        }

        return view("user.sections.adRequestDetails", compact("ad", "page"));


    }

}
