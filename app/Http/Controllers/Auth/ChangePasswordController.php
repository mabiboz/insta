<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function change(Request $request)
    {
        $this->validate($request,[
            "oldPassword" => "required",
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ],[
            "oldPassword.required" => 'کلمه عبور فعلی را وارد نمایید !',
            'password.required' => 'کلمه عبور جدید را وارد نمایید !',
            'password.min' => 'کلمه عبور باید حداقل 6 کارکتر باشد !',
            'password.confirmed' => 'لطفا فیلدهای کلمه عبور را یکسان وارد نمایید !',
            'password_confirmation.required' => 'تکرار کلمه عبور الزامی می باشد !',
        ]);

        $user = Auth::user();
        $hashedPassword = $user->password;
        if(!Hash::check($request->oldPassword, $hashedPassword)){
            flash_message("کلمه عبور فعلی اشتباه وارد شده است !","danger");
            return back();
        }
        $result = $user->update([
            "password" => bcrypt($request->password),
        ]);
        if($result){
            flash_message("کلمه عبور با موفقیت تغییر یافت !","success");
            return back();
        }else{
            flash_message("مشکلی رخ داده ! بعدا امتحان کنید.","danger");
            return back();
        }
    }
}
