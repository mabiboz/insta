<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\User\AdsController;
use App\Helper\PayWalletAndLog;
use App\Http\Requests\PageRequest;
use App\Models\Ad;
use App\Models\Adstatistics;
use App\Models\Campain;
use App\Models\CategoryPage;
use App\Models\Page;
use App\Models\PageLastVersion;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{

    public function sendAdFromMabino(Page $page,Request $request)
    {

        $adsFromMabino = Ad::where("status",Ad::OK)->where("soft_delete",0)->whereHas("user", function ($q) {
            $q->where("role", User::ROLE_MABINO);
        })->latest()->get();
        $fullPrice = 0;
        foreach ($adsFromMabino as $ad) {
            if ($ad->is_mabinoe) {
                $fullPrice += 0.5 * $page->price;
            } else {
                $fullPrice += $page->price;
            }
        }
        if (is_null(Auth::user()->wallet)) {
            Wallet::create([
                "user_id" => Auth::user()->id,
                "sum" => 0,
            ]);
        }
        if ($fullPrice > Auth::user()->wallet->sum) {
            flash_message("لطفا کیف پول مابینو را شارژ نمایید !", "danger");
            return back();
        }


        foreach ($adsFromMabino as $ad) {

            /*update expireAt Ad*/
            $ad->update([
                "expired_at" =>Carbon::now()->addDay(),
            ]);

            //pay wallet and log wallet
            $price = $page->price;
            if ($ad->is_mabinoe) {
                $price = 0.5 * $price;
            }

            $payAndLog = new PayWalletAndLog($price, Auth::user(), WalletLog::ADD_AD);
            $resultPayAndLog = $payAndLog->decrease();


            if (!$resultPayAndLog['result']) {
                flash_message($resultPayAndLog['message'], "danger");
                return back();
            }


            /*create new campain*/
            $newCampain = Campain::create([
                "user_id" => Auth::user()->id,
                "title" => "mabino.ir",
            ]);

            /*attach page to campain*/
            $newCampain->pages()->attach($page->id);


            /*create pageRequest records*/


            $pagerequest = \App\Models\PageRequest::create([
                'page_id' => $page->id,
                'ad_id' => $ad->id,
                'status' => \App\Models\PageRequest::PENDING,
            ]);
            $statistics = Adstatistics::create([
                'pagerequest_id' => $pagerequest->id,
            ]);


            /*attach ad to campain*/
            $ad->campains()->attach($newCampain->id);


        }


        $page->update([
            "getmabino_ad" => 1,
        ]);

        getmabinoads($page->user->name,$page->user->mobile);

        flash_message("عملیات با موفقیت انجام شد !","success");
        return back();
    }


    public function pagesnotverified()
    {
        $pages=Page::where('status',0);
        $pages = searchItems(['name','city.name','categoryPage.name','instapage_id'],$pages);
        $pages =  $pages->latest()->paginate(500);
        $title = "لیست صفحات تایید نشده";
        return view('admin.pages.all', compact('pages','title'));
    }

    public function pagesverified()
    {
        $pages=Page::where('status',1);
        $pages = searchItems(['name','city.name','categoryPage.name','instapage_id'],$pages);
        $pages =  $pages->latest()->paginate(500);
        $title = "لیست صفحات تایید شده";
        return view('admin.pages.all', compact('pages','title'));
    }

    public function all()
    {
        $pages=Page::query();
        $pages = searchItems(['name','city.name','categoryPage.name','instapage_id'],$pages);
        $pages =  $pages->latest()->paginate(500);
        return view('admin.pages.all', compact('pages'));
    }

    public function changestate(Request $request)
    {

        $pageid = $request->id;
        $price = $request->price;

        $status = $request->status;
        if ($status == 0) {

            if (!is_null($price)) {
                Page::find($pageid)->update(['price' => $price / 10]);
            }

            $page = Page::find($pageid)->update(['status' => Page::ACTIVE]);

            $pageItem = Page::find($pageid);
            PageLastVersion::create([
                "page_id"=>$pageItem->id,
                'name' => $pageItem->name,
                'instapage_id' => $pageItem->instapage_id,
                'categorypage_id' => $pageItem->categorypage_id,
                'city_id' =>$pageItem->city_id,
                "price" =>$price,
                'all_members' => $pageItem->all_members,
                'fake_members' => $pageItem->fake_members,
                'sex'=> $pageItem->sex,
                'age_contact' =>$pageItem->age_contact,
                'suggestprice'=>$pageItem->suggestprice
            ]);

            if ($page) {
                Page::find($pageid)->user->update([
                    "is_admin" => 1,
                ]);
                return 'active';

            }
            return 'error';
        } else {
            $page = Page::find($pageid)->update([
                'status' => Page::INACTIVE,
                'reason' => is_null($request->reason) ? 'بدون دلیل' : $request->reason,
            ]);
            if ($page) {
                return 'inactive';

            }
            return 'error';
        }

    }
    public function delete(Page $page)
    {
        $result =  $page->delete();
        if ($result) {
            flash_message("صفحه  با موفقیت حذف شد !", 'success');
        } else {
            flash_message("مشکلی رخ داده ! دوباره امتحان کنید !", 'danger');
        }
        return redirect()->back();
    }

    public function edit(Page $page)
    {
        $categories = CategoryPage::all();
        return view("admin.pages.edit",compact("page","categories"));
    }

    public function update(Request $request,Page $page)
    {
        $result = $page->update([
            'categorypage_id' => $request->categorypage,
            'name' => $request->name,
            'instapage_id' => $request->instapage_id,
            'price'=>$request->price,
            'fake_members'=>$request->fake_members,
            'all_members'=>$request->all_members,
        ]);
        if ($result) {
            flash_message("صفحه  با موفقیت بروزرسانی شد !", 'success');
        } else {
            flash_message("مشکلی رخ داده ! دوباره امتحان کنید !", 'danger');
        }
        return redirect()->route("admin.page.all");
    }


    public function getDetailsAjax(Request $request)
    {
        $pageId = $request->id;
        $page = Page::find($pageId);
        if(!$page){
            exit;
        }
        $pageSex = Page::getSexPage();
        $ageContact = Page::getContactAge();
        $html = view("admin.pages.sections.ajaxViewForDetails",compact("page","pageSex","ageContact"))->render();
        return response($html);
    }



    public function planA_list()
    {
        $pages=Page::where('plan','a');
        $pages = searchItems(['name','city.name','categoryPage.name','instapage_id'],$pages);
        $pages =  $pages->latest()->paginate(500);
        $title = "لیست صفحات سیستمی";
        return view('admin.pages.all', compact('pages','title'));
    }

    public function planB_list()
    {
        $pages=Page::where('plan','b');
        $pages = searchItems(['name','city.name','categoryPage.name','instapage_id'],$pages);
        $pages =  $pages->latest()->paginate(500);
        $title = "لیست صفحات دستی";
        return view('admin.pages.all', compact('pages','title'));
    }

}
