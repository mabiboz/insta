<?php

namespace App\Http\Controllers\User;

use App\Helper\PayWalletAndLog;
use App\Http\Requests\CampainRequest;
use App\Models\Ad;
use App\Models\Adstatistics;
use App\Models\Campain;
use App\Models\CategoryPage;
use App\Models\FavoriteAd;
use App\Models\Image;
use App\Models\Page;
use App\Models\PageRequest;
use App\Models\Province;
use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class UserCampainsController extends Controller
{

    public function ajaxValidation(Request $request)
    {
        $countPageSelected = $request->countPageSelected;
        $campain_name = $request->campain_name;
        $ad_content = $request->ad_content;
        $expired_at = $request->expired_at;
        $messages = [];

        if ($countPageSelected == 0) {
            $messages[] = "لطفا پیج های خود را انتخاب نمایید !";
        }

        if (!strlen($ad_content)) {
            $messages[] = "لطفا محتوا آگهی را وارد نمایید !";
        }

        if (!strlen($campain_name)) {
            $messages[] = "لطفا عنوان کمپین را وارد نمایید !";
        }

        if (!strlen($expired_at)) {
            $messages[] = "تعیین مدت پذیرش آگهی الزامی می باشد !";
        }

        if (count($messages)) {
            return response()->json(['result' => 0, 'msgs' => $messages]);
        }
        return response()->json(['result' => 1]);

    }

    public function index()
    {

        $user = Auth::user();
        $campains = $user->campains;
        return view("user.campains.index", compact("campains"));
    }

    public function getDescription($id)
    {
        $campain = Campain::find($id);
        $ad = $campain->ads->first();

        return view("user.campains.sections.ajaxForDetailAdCampain", compact("ad"));

    }

    public function getCampainPagesAjax(Request $request)
    {

        $id = $request->id;
        $campain = Campain::find($id);
        $userCampainsID = Auth::user()->campains()->pluck("id")->toArray();
        if (!$campain or !in_array($id, $userCampainsID)) {
            return "Not Found !";
        }
        $pages = $campain->pages;
        $ad = $campain->ads()->first();

        foreach ($pages as $page) {
            $pageRequest = PageRequest::where('ad_id', $ad->id)->where('page_id', $page->id)->first();
            $adstatiscit = Adstatistics::where('pagerequest_id', $pageRequest->id)->first();
            if (isset($adstatiscit)) {
                $page->pageRequestStatus = $pageRequest->status;
                $page->like = $adstatiscit->likecount;
                $page->comment = $adstatiscit->commentcount;
                $page->view = $adstatiscit->viewcount;
                $page->followers = $adstatiscit->followers;
                $page->endshow = $adstatiscit->endshow;
                $page->end_work = $adstatiscit->end_work;

            } else {
                $page->pageRequestStatus = $pageRequest->status;
                $page->pageRequestLink = $pageRequest->link;
                $page->like = 0;
                $page->comment = 0;
                $page->view = 0;
                $page->followers = 0;
                $page->end_work = 0;
            }

        }

        $html = view("user.campains.sections.ajaxViewForPageListAndDetails", compact("pages", "ad"))->render();
        return response($html);

    }


    public function create()
    {

        $categoriesPage = CategoryPage::all();
        $provinces = Province::all();
        $sexPage = Page::getSexPage();
        $contactAge = Page::getContactAge();
        return view("user.campains.create", compact("categoriesPage", "provinces", "sexPage", "contactAge"));
    }

    public function getPages(Request $request)
    {

        $category_id = $request->category_id;
        $province_id = $request->province_id;
        $age_contact = $request->age_contact;
        $sex_page = $request->sexPage;
        $filter = $request->filter;



        /*get query builder of active Pages*/

        $pages = Page::where(function ($q) {
            $q->where("status", Page::ACTIVE)->where("plan", "a")->has("pagedetail");
        })->orWhere(function ($q) {
            $q->where("status", Page::ACTIVE)->where("plan", "b");
        });


        /*filter Pages query builder by province*/
        if ($province_id > 1) {
            $pages = $pages->where("city_id", $province_id);
        }

        /*filter pages query builder by categoryPages*/
        if ($category_id != 1) {
            $categoryPage = CategoryPage::find($category_id);
            $pages->where("categorypage_id", $categoryPage->id);
        }


        /*filter pages query builder by sexPages*/
        if ($sex_page != Page::BOTH) {
            $pages->where("sex", $sex_page);
        }


        /*filter pages query builder by age contact*/
        if ($age_contact != Page::ALL_AGE) {
            $pages->where("age_contact", $age_contact);
        }




        /*sort pages with filters (min_price = 1, max_price= 2,min_follower = 3 ,max_follower = 4 )*/
        if(isset($filter)){
            if($filter == 1){ // min_price
                $pages = $pages->orderBy("price","ASC");
            }

            if($filter == 2){ // max_price
                $pages = $pages->orderBy("price","DESC");
            }

            if($filter == 3){ // min_follower
                $pages = $pages->orderBy("all_members","ASC");
            }


            if($filter == 4){ // max_follower
                $pages = $pages->orderBy("all_members","DESC");
            }

        }




        $pages = $pages->get();


        $resultHtml = view("user.campains.sections.ajaxSearchPages", compact("pages","filter"))->render();
        return response(["result" => 1, "content" => $resultHtml]);

    }


    protected function validationImageOrVideoFile($fileItem)
    {
        $fileExtension = $fileItem->getClientMimeType();
        $fileSize = $fileItem->getSize();

        $mimeTypesImage = [
            'image/jpeg',
            'image/png',
            'image/gif',
        ];

        $mimeTypesVideo = [
            'video/mpeg',
            'video/ogg',
            'video/mp4',
        ];

        if (in_array($fileExtension, $mimeTypesImage)) {

            if ($fileSize <= 200000) {//200KB
                return ['result' => 1];
            } else {
                return ['result' => 0, 'message' => 'سایز تصویر باید کمتر از 200 کیلوبایت باشد .'];
            }
        } elseif (in_array($fileExtension, $mimeTypesVideo)) {
            if ($fileSize <= 20000000) {//20MB
                return ['result' => 1];
            } else {
                return ['result' => 0, 'message' => 'سایز ویدیو باید کمتر از 20 مگابایت باشد .'];
            }
        } else {
            return ['result' => 0, 'message' => 'لطفا فایل های عکس یا ویدیو آپلود کنید .'];
        }


    }


    public function invoice(CampainRequest $request)
    {
        /*validate file uploaded */

        if ($request->hasFile('ad_image')) {
            $validationResult = $this->validationImageOrVideoFile($request->file('ad_image'));
            if (!$validationResult['result']) {
                flash_message($validationResult['message'], 'danger');
                return back();
            }
        }

        /*end validate file uploaded */


        Session::forget("ad_image_name");
        Session::forget("campain_data");
        Session::forget("cover_image_name");


        /*upload image */
        if ($request->hasFile("ad_image")) {
            $imageFile = $request->file("ad_image");
            $imageName = "ad_" . time() . "_" . rand(1, 99);
            $imageName .= "." . $imageFile->getClientOriginalExtension();
            $imageName = strtolower($imageName);
            $imagePath = public_path() . config("UploadPath.ad_image_path");
            $imageFile->move($imagePath, $imageName);


            $typeMedia = explode('/', $imageFile->getClientMimeType())[0];

            Session::put("ad_image_name", $imageName);
        } else {
            $favoriteAd_id = $request->isAddDataFromFavoriteList;
            $favoriteAd = FavoriteAd::find($favoriteAd_id);

            $adFileFavExtensionArray = explode('.', $favoriteAd->ad_file);
            $lastKey = count($adFileFavExtensionArray) - 1;
            $adFileFavExtension = $adFileFavExtensionArray[$lastKey];

            $typesImage = [
                'jpeg',
                'jpg',
                'png',
                'gif',
            ];


            if (in_array($adFileFavExtension, $typesImage)) {
                $typeMedia = "image";
            } else {
                $typeMedia = "video";
            }


            Session::put("ad_image_name", $favoriteAd->ad_file);
        }


        /*put data request except file in to session*/
        $campain_data = $request->except("ad_image", "cover");
        Session::put("campain_data", $campain_data);


        $pages_id = $request->pages_id;
        $pages = Page::find($pages_id);

        $sexPages = Page::getSexPage();
        $age_contact = Page::getContactAge();

        /*upload cover image*/

        if ($request->hasFile("cover")) {
            $imageFileCover = $request->file("cover");
            $imageNameCover = "cover" . time() . "_" . rand(1, 99);
            $imageNameCover .= "." . $imageFileCover->getClientOriginalExtension();
            $imageNameCover = strtolower($imageNameCover);
            $imagePathCover = public_path() . config("UploadPath.cover_image_path");
            $imageFileCover->move($imagePathCover, $imageNameCover);


            Session::put("cover_image_name", $imageNameCover);
        }
        /*end upload cover image*/

        return view("user.campains.invoice", compact("typeMedia", "pages", "sexPages", "age_contact", "campain_data"));
    }


    public function store(Request $request)
    {


        //get id of selected page in factor
        $selectPages = $request->selectPage;

        //get data campain from session and get  ad_image from temporary path To save in DB
        $campain_data = \session("campain_data");
        $ad_image_name = \session("ad_image_name");


        if (!Session::exists("cover_image_name")) {
            $cover_image_name = "defaultCover.jpg";
        } else {
            $cover_image_name = \session("cover_image_name");

        }

        $expired_date = explode('/', EnFormat($campain_data['expired_at']));
        $expired_date = CalendarUtils::toGregorianDate($expired_date[0], $expired_date[1], $expired_date[2]);


        //unset pageId that not selected in factor from campain data
        foreach ($campain_data['pages_id'] as $key => $value) {
            if (!in_array($value, $selectPages)) {
                unset($campain_data['pages_id'][$key]);
            }
        }

        //pay wallet and log wallet
        $price = 0;
        foreach ($campain_data['pages_id'] as $item_id) {
            $price += Page::find($item_id)->price;
        }
        $price = $price * getRatio($campain_data['dayCount']);

        $payAndLog = new PayWalletAndLog($price, Auth::user(), WalletLog::ADD_AD);
        $resultPayAndLog = $payAndLog->decrease();


        if (!$resultPayAndLog['result']) {
            flash_message($resultPayAndLog['message'], "danger");
            return redirect()->route("user.campain.create");
        }


        /*create new campain*/
        $newCampain = Campain::create([
            "user_id" => Auth::user()->id,
            "title" => $campain_data["campain_name"],
            'cover' => $cover_image_name,

        ]);

        /*attach page to campain*/
        $newCampain->pages()->attach($campain_data['pages_id']);

        /*join hashtags to ad_content*/
        $adContent = $campain_data['ad_content'] . "\n" . "#mabino.ir" . "\n" .
            "#ariapardaz.ir" . "\n" .
            "#مجری_تبلیغات_مابینو" . "\n";
        /*create ad*/
        $newAd = Ad::create([
            "user_id" => Auth::user()->id,
            "content" => $adContent,
            "day_count" => $campain_data['dayCount'],
            "expired_at" => $expired_date,
        ]);


        /*create pageRequest records*/

        foreach ($campain_data['pages_id'] as $page_id) {
            $pagerequest = PageRequest::create([
                'page_id' => $page_id,
                'ad_id' => $newAd->id,
                'status' => PageRequest::PENDING,
            ]);

            $statistics = Adstatistics::create([
                'pagerequest_id' => $pagerequest->id,
            ]);


        }


        /*attach ad to campain*/
        $newAd->campains()->attach($newCampain->id);

        /*upload  and create record for Ad image*/
        if (!is_null($ad_image_name)) {
            // $fileInTemporary = config('UploadPath.ad_image_path_temporary') . $ad_image_name;

            // $pathToSaveFile = config('UploadPath.ad_image_path') . $ad_image_name;

            // Storage::move($fileInTemporary, $pathToSaveFile);


            $newImage = Image::create([
                "name" => $ad_image_name,
                "ad_id" => $newAd->id,
            ]);


            if (!$newCampain or !$newAd) {
                flash_message("مشکلی در ایجاد کمپین رخ داده . لطفا دوباره امتحان نمایید .", "danger");
                return back();
            }


        }

        flash_message("کمپین با موفقیت ایجاد شد !", "success");
        return redirect()->route("user.campain.create");

    }

    public function addToFav()
    {
        $campain_data = \session("campain_data");
        $ad_image_name = \session("ad_image_name");

        $favoriteItem = Auth::user()->favoriteAds()
            ->where('campain_name', $campain_data['campain_name'])
            ->where('ad_content', $campain_data['ad_content'])
            ->where('ad_file', $ad_image_name)->get();
        if (count($favoriteItem)) {
            return response(['result' => -1]); //before added to list
        }

        $newFav = FavoriteAd::create([
            "user_id" => Auth::user()->id,
            "campain_name" => $campain_data['campain_name'],
            "ad_content" => $campain_data['ad_content'],
            "ad_file" => strtolower($ad_image_name),
        ]);
        if ($newFav) {
            return response(['result' => 1]); // successFully added to List
        }
        return response(['result' => 0]); // Failed add to list

    }

    public function getDataCampainFromFavoriteList(Request $request)
    {
        $user = Auth::user();
        $favorites = $user->favoriteAds;
        $html = view("user.campains.sections.favoriteAdListAjax", compact("favorites"))->render();
        return response($html);
    }

    public function getDataFromFavoriteListAndPutToForm(Request $request)
    {
        $fav_id = $request->favid;
        $favoriteData = Auth::user()->favoriteAds()->where('id', $fav_id)->first();
        if (!$favoriteData) {
            exit;
        }
        return $favoriteData;

    }
}
