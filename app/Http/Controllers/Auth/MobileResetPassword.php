<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MobileResetPassword extends Controller
{

    public function showFormGetMobile(Request $request)
    {
        $html = view("auth.sections.formForGetMobile")->render();
        return response($html);
    }
    public function getMobile(Request $request)
    {
        $mobile = $request->mobile;
        if(is_null($mobile)){
            return "لطفا موبایل خود را وارد نمایید !";
        }
        $mobile = EnFormat($mobile);

        $user = User::where('mobile',$mobile)->first();
        if(is_null($user)){
            return "هیچ کاربری با این شماره موبایل یافت نشد !";
        }

        $user->update([
            'activation_code' => rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9),
        ]);

        sendResetPasswordVerifyMobile($mobile, $user->activation_code);

        $html = view("auth.sections.formForGetActivationCode")->render();
        session(['resetPasswordUser' => $user]);
        return response($html);

    }

    public function verifyMobile(Request $request)
    {
        $code = $request->input('data');
        $user = session('resetPasswordUser');
        if($user->activation_code == $code){
            $html = view("auth.sections.resetPasswordForm")->render();
            return response($html);
        }else{
            return "کد وارد شده صحیح نمی باشد !";
        }



    }

    public function resetPassword(Request $request)
    {
        $user = session('resetPasswordUser');
        $result =$user->update([
            'password' => bcrypt($request->newPassword),
        ]);
        if($result){
            return redirect()->route('login')->with(['resetPasswordSuccess'=> 'کلمه عبور با موفقیت تغییر یافت ']);
        }
        return redirect()->route('login')->with(['resetPasswordError'=> 'متاسفانه مشکلی در هنگام تغییر کلمه عبور رخ داده']);


    }
}
