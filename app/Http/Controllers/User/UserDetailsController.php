<?php

namespace App\Http\Controllers\User;


use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDetailsController extends Controller
{
    public function getDetail()
    {
        $data = Auth::user()->userDetails;
        return view("user.userDetail.form",compact("data"));
    }

    public function addDetail(Request $request)
    {
        $this->validate($request,[
            'cart'=>'required',
            'account_number'=>'required',
        ],[
            'cart.required'=>'شماره کارت اجباری است .',
            'account_number.required'=>'شماره حساب اجباری است .',
        ]);

        $userDetail = Auth::user()->userDetails;
        if($userDetail){
            $result = $userDetail->update([
                "sheba" => $request->sheba,
                "account_number" => $request->account_number,
                "cart" => $request->cart,
            ]);
        }else{
            $result = UserDetail::create([
                "sheba" => $request->sheba,
                "account_number" => $request->account_number,
                "cart" => $request->cart,
                "user_id"=>Auth::user()->id,
            ]);
        }

        if($result){
            flash_message("اطلاعات بانکی با موفقیت ثبت شد !",'success');
            return back();
        }


        flash_message("خطا در ثبت اطلاعات",'danger');
        return back();
    }
}
