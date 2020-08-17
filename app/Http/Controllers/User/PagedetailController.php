<?php

namespace App\Http\Controllers\User;

use App\Models\Page;
use App\Models\PageDetail;
use App\customclass\postToInstagram;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PagedetailController extends Controller
{
    public function addDetail(Request $request)
    {
        $pageid = $request->id;
        $page=Page::find($pageid);
        if(isset($page->pagedetail)){
            $username=$page->pagedetail->username;
            $password=$page->pagedetail->password;

        }else{
            $username='';
            $password='';
        }
        return view('user.pageDetail.sections.getPageDetail',compact('username','password','pageid'));
    }

    public function edit(Request $request)
    {
        $user=Auth::user();
        $pageids=$user->pages->pluck('id')->toArray();
        if(!in_array($request->page_id,$pageids)){
            abort('404');
        }
       $page=Page::find($request->page_id);
       

        $username = $request->username;
        $password = $request->password;

           
        
      $newAttemp=new postToInstagram();
       
      $loginResult = $newAttemp->checkLogin($username, $password);
     
   

        

        if( !isset($loginResult['invalid_credentials']) ){
            connecttomabino($page->user->name,$page->user->mobile);

            if($page->pagedetail){
                $page->pagedetail->update([
                    'username'=>$request->username,
                    'password'=>$request->password,
                ]);
            
            
            }else{
                $newDetail = PageDetail::create([
                    "page_id" => $page->id,
                    'username'=>$request->username,
                    'password'=>$request->password,
                ]);
          
            }

        flash_message('با موفقیت انجام شد','success');
        
        return redirect()->back();
        

        }else{
            
             if($page->pagedetail){
                $page->pagedetail->delete();
            
            
            }
              
        flash_message('نام کاربری یا رمزعبور اینستاگرام شما اشتباه وارد شده است ','danger');
        
        return redirect()->back();

          
        }

        
      


    }
}
