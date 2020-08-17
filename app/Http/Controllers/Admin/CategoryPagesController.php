<?php

namespace App\Http\Controllers\Admin;

use App\Models\CategoryPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryPagesController extends Controller
{
    public function index()
    {
        $categories = CategoryPage::all();
        return view("admin.categoryPages.index", compact("categories"));

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'عنوان دسته بندی را وارد نمایید !',
        ]);
        $newCategory =  CategoryPage::create([
            'name' => $request->name,
        ]);
        if($newCategory){
            flash_message("دسته بندی با موفقیت ثبت شد !",'success');
        }else{
            flash_message("مشکلی رخ داده است !",'danger');
        }
        return back();

    }

    public function edit(CategoryPage $category)
    {
        $categories = CategoryPage::all();
        return view("admin.categoryPages.index",compact("category","categories"));
    }

    public function update(CategoryPage $category,Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'عنوان دسته بندی را وارد نمایید !',
        ]);
        $result =$category->update([
            'name' =>$request->name,
        ]);
        if($result){
            flash_message("با موفقیت بروزرسانی شد !",'success');
        }else{
            flash_message("مشکلی رخ داده !",'danger');
        }
        return redirect()->route('admin.categoryPage.index');
    }
}
