<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AutoSendController extends Controller
{
    public function create()
    {
        $allowAutoSend = Auth::user()->autosend;
        return view("user.autoSend.create",compact("allowAutoSend"));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $result = $user->update([
            'autosend' => isset($request->allow) ? 1 : 0,
        ]);
        if($result){
            flash_message("با موفقیت ثبت شد !",'success');
        }else{
            flash_message("خطا در ثبت اطلاعات !",'danger');
        }
        return back();
    }
}
