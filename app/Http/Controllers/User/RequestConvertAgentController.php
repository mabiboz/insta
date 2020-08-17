<?php

namespace App\Http\Controllers\User;

use App\Models\AgentLevel;
use App\Models\AgentRequest;
use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class RequestConvertAgentController extends Controller
{


    public function selectAgentLevel()
    {
        $levels = AgentLevel::all();
        $html = view("layouts.user.sections.agentLevelsModal",compact("levels"))->render();
        return response($html);
    }

    public function requestConvertToAgent(Request $request)
    {
        $user = Auth::user();
        $userWallet = $user->wallet;
        $level = $request->agentLevel;
        $levelItem = AgentLevel::find($level);

        if($levelItem->price > $userWallet->sum){
            flash_message("اعتبار کیف پول شما برای درخواست نمایندگی کافی نمی باشد !",'danger');
            return back();
        }


        $walletDecreament = $userWallet->update([
            'sum' => $userWallet->sum - $levelItem->price,
        ]);
        if(!$walletDecreament){
            flash_message("خطا",'danger');
            return back();
        }

        WalletLog::create([
            'user_id'=>$user->id,
            'price' => $levelItem->price,
            'method_create' => WalletLog::CONVERT_TO_AGENT,
            'wallet_operation' =>WalletLog::DECREMENT,
        ]);



        if (!is_null($user->agentRequest) and $user->agentRequest->status == AgentRequest::FAILED) {
            $newRequestAgent = $user->agentRequest->update([
                "status" => AgentRequest::PENDING,
                "agentlevel" => $level
            ]);
        } else {
            $newRequestAgent = AgentRequest::create([
                "user_id" => $user->id,
                "agentlevel" => $level

            ]);
        }
        if ($newRequestAgent) {
            flash_message("درخواست با موفقیت ثبت شد !", 'success');
        } else {
            flash_message("متاسفانه مشکلی در ارسال درخواست رخ داده ! چند لحظه بعد تلاش کنید .", 'danger');
        }
        return back();
    }
}
