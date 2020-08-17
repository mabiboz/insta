<?php

namespace App\Http\Controllers\User;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->get();
        return view("user.news.index",compact("news"));
    }

    public function detail(Request $request)
    {
        $news_id = $request->id;
        $news = News::find($news_id);
        if(!$news){
            return 'متاسفانه خبر یافت نشد !';
        }
        $html = view("user.news.sections.detail",compact("news"))->render();
        return response()->json($html);
    }

}
