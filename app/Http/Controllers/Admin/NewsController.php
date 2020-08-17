<?php

namespace App\Http\Controllers\Admin;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();
        return view("admin.news.index", compact("news"));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
        ], [
            'content.required' => 'محتوای خبر الزامی می باشد !',
        ]);

        if ($request->hasFile('image')) {
            $imageFile = $request->file("image");
            $imageName = "news_" . time() . "_" . rand(1, 99);
            $imageName .= "." . $imageFile->getClientOriginalExtension();
            $imagePath = public_path() . config("UploadPath.news_image_path");
            $imageFile->move($imagePath, $imageName);
        } else {
            $imageName = null;
        }

        $newNews = News::create([
            "title" => $request->input('title'),
            "content" => $request->input('content'),
            "image" => $imageName
        ]);
        if($newNews instanceof News){
            flash_message("اخبار جدید با موفقیت اعلان شد !","success");
        }else{
            flash_message("مشکلی در ثبت و اعلان خبر رخ داده !","danger");
        }

        return back();


    }

    public function delete(News $news)
    {
        $news->delete();
        flash_message("با موفقیت حذف شد !","success");
        return back();
    }
}
