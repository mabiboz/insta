<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\PageRequest;
use App\Models\CategoryPage;
use App\Models\Page;
use App\Models\PageLastVersion;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class PagesController extends Controller
{

    public function index()
    {
        $pages = Auth::user()->pages;
        $ageContacts = Page::getContactAge();
        $sexContact = Page::getSexPage();
        return view("user.pages.index", compact("pages","ageContacts","sexContact"));

    }

    public function create()
    {
        $allState = Province::all();
        $categories = CategoryPage::all();
        $sexPage = Page::getSexPage();
        $contactAge = Page::getContactAge();
        return view("user.pages.create", compact("categories","allState","sexPage","contactAge"));
    }

    public function store(PageRequest $request)
    {

        $instagramID = $request->instapage_id;
        if(substr($request->instapage_id,0,1) != "@"){
            $instagramID = "@" . $instagramID;
        }

        $newPage = Page::create([
            'user_id' => Auth::user()->id,
            'categorypage_id' => $request->categorypage,
            'name' => $request->name,
            'status' =>Page::INACTIVE,
            'instapage_id' => $instagramID,
            'city_id' =>$request->state,
            'all_members' => $request->all_members,
            'fake_members' => $request->fake_members,
            'sex'=> $request->sex,
            'age_contact' =>$request->age_contact,
            'plan' => $request->plan,
            'suggestprice'=>is_null($request->suggestprice) ? 0 : $request->suggestprice

        ]);


        if ($newPage) {
            PageLastVersion::create([
                "page_id"=>$newPage->id,
                'name' => $request->name,
                'instapage_id' => $instagramID,
                'categorypage_id' => $request->categorypage,
                'city_id' =>$request->state,
                'all_members' => $request->all_members,
                'fake_members' => $request->fake_members,
                'sex'=> $request->sex,
                'age_contact' =>$request->age_contact,
                'suggestprice'=>is_null($request->suggestprice) ? 0 : $request->suggestprice
            ]);

            flash_message("صفحه جدید با موفقیت ایجاد شد !", 'success');
        } else {
            flash_message("مشکلی رخ داده ! دوباره امتحان کنید !", 'danger');
        }

        return redirect()->route("user.pages.index");

    }


    public function edit(Page $page)
    {
        $allState = Province::all();
        $categories = CategoryPage::all();
        $contactAge = Page::getContactAge();
        $sexPage = Page::getSexPage();
        return view("user.pages.edit",compact("page","categories","allState","contactAge","sexPage"));
    }

    public function update(PageRequest $request,Page $page)
    {
        $instagramID = $request->instapage_id;
        if(substr($request->instapage_id,0,1) != "@"){
            $instagramID = "@" . $instagramID;
        }
        $result = $page->update([
            'categorypage_id' => $request->categorypage,
            'name' => $request->name,
            'instapage_id' => $instagramID,
            'city_id' =>$request->state,
            'status' =>Page::INACTIVE,
            'all_members' => $request->all_members,
            'fake_members' => $request->fake_members,
            'sex'=> $request->sex,
            'age_contact' =>$request->age_contact,
            'plan' => $request->plan

        ]);

        if ($result) {
            flash_message("صفحه  با موفقیت بروزرسانی شد !", 'success');
        } else {
            flash_message("مشکلی رخ داده ! دوباره امتحان کنید !", 'danger');
        }
        return redirect()->route("user.pages.index");
    }

    /*get city*/
    public function getCity(Request $request)
    {
        $stateID = $request->stateID;
        $state = Province::find($stateID);
        if (!$state) {
            exit;
        }
        $allCity = $state->city;
        $allCity = $allCity->pluck('name', 'id');
        return response()->json($allCity);

    }
    public function getReasonAbort(Request $request)
    {
        $page_id=$request->id;
        $reason=Page::find($page_id)->reason;
        return 'دلیل رد پیج: '.$reason;
    }


    public function publicationchange(Page $page)
    {
        if($page->plan=='a'){

            $page->update([
                'plan'=>'b'
            ]);
            flash_message("صفحه  با موفقیت بروزرسانی شد !", 'success');
            return back();
        }else{

            $page->update([
                'plan'=>'a'
            ]);
            flash_message("صفحه  با موفقیت بروزرسانی شد !", 'success');
            return back();
        }
    }


}
