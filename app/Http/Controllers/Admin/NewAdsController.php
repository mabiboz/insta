<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use App\Models\Image;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NewAdsController extends Controller
{
    public function create()
    {
        $ads = Ad::where("soft_delete",0)->whereHas("user",function ($q){
            $q->where("role",User::ROLE_MABINO);
        })->latest()->get();
        return view("admin.newAd.create",compact("ads"));
    }



    public function store(Request $request)
    {
        $this->validate($request, [
            'ad_content' => 'required|max:960',
            'ad_image' => 'required',
        ], [
            'ad_content.required' => 'محتوای آگهی را وارد نمایید .',
            'ad_content.max' => 'محتوای آگهی نباید بیشتر از 960 کارکتر باشد .',
            'ad_image.required' => 'فایل رسانه را آپلود نمایید !',
        ]);


        $is_mabinoe =0 ;
        if(isset($request->is_mabinoe)){
            $is_mabinoe =1;
        }



        $expired_date = Carbon::now()->addDay();






        /*join hashtags to ad_content*/
        $adContent =$request->ad_content ."\n". "#mabino.ir" ."\n".
            "#ariapardaz.ir"."\n".
            "#مجری_تبلیغات_مابینو"."\n";
        /*create ad*/
        $newAd = Ad::create([
            "user_id" => Auth::user()->id,
            "content" => $adContent,
            "day_count" => 1,
            "expired_at" => $expired_date,
            "is_mabinoe" => $is_mabinoe,
             "status" => Ad::OK,

        ]);

        /*create pageRequest records*/




        /*upload  and create record for Ad image*/
        /*upload image */
        if ($request->hasFile("ad_image")) {
            $imageFile = $request->file("ad_image");
            $imageName = "ad_" . time() . "_" . rand(1, 99);
            $imageName .= "." . $imageFile->getClientOriginalExtension();
            $imageName = strtolower($imageName);
            $imagePath = public_path() . config("UploadPath.ad_image_path");
            $imageFile->move($imagePath, $imageName);
            $typeMedia = explode('/',$imageFile->getClientMimeType())[0];
            $newImage = Image::create([
                "name" => $imageName,
                "ad_id" => $newAd->id,
            ]);
        }


        flash_message("آگهی با موفقیت ایجاد شد !", "success");
        return back();

    }

    public function delete(Ad $ad)
    {
        if($ad->user->role != User::ROLE_MABINO){
            abort(404);
        }

        $ad->update([
            "soft_delete" => 1,
            ]);
        flash_message("آگهی با موفقیت حذف شد !", "success");
        return back();
    }
    
        public function changeStatus(Ad $ad)
    {
        $staus = $ad->status;

        $new_status = Ad::PENDING;
        if ($staus == Ad::OK) {
            $new_status = Ad::FAILED;
        } else {
            $new_status = Ad::OK;
        }
        $ad->update([
            "status" => $new_status,
        ]);
        flash_message("با موفقیت انجام شد !","success");
        return back();
    }
}
