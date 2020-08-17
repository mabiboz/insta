<?php

namespace App\Http\Controllers\Admin;

use App\Models\AgentRequest;
use App\Models\User;

use App\Models\WalletLog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentRequestsController extends Controller
{
    public function index()
    {
        $agentRequests = AgentRequest::latest()->paginate(20);
        $agentRequestStatus = AgentRequest::getStatusAgentRequest();
        return view("admin.agentRequest.index", compact("agentRequests", "agentRequestStatus"));
    }

    public function changeState(Request $request)
    {
        $newStatus = $request->newStatus;
        $agentRequest_id = $request->id;
        
        

        if ($newStatus == 2) {
            $agentRequest = AgentRequest::find($agentRequest_id);
            $resultUpdated = $agentRequest->update(['status' => AgentRequest::ACCEPTED]);

            if ($resultUpdated) {
                $user = $agentRequest->user;
                $user->update([
                    "role" => User::ROLE_AGENT,
                    "reagent_code" => "mb-" . rand(100, 999) . $user->id,

                ]);
                acceptagent($user->name,$user->mobile);

            }

        } else {
            $agentRequest = AgentRequest::find($agentRequest_id);
            $user = $agentRequest->user;
            $user->update([
                "role" => User::ROLE_USER,
                "reagent_code" => null,

            ]);
            $agentRequest->update([
                'status' => AgentRequest::FAILED,
                'reason' => $request->reason_content,
            ]);
            
            
            $user->wallet->update([
                'sum' => $user->wallet->sum + $agentRequest->agentLevel->price,
            ]);


            WalletLog::create([
                'user_id'=>$user->id,
                'price' => $agentRequest->agentLevel->price,
                'method_create' => WalletLog::NOT_VERIFIED_REAGENT,
                'wallet_operation' =>WalletLog::INCREMENT,
            ]);

        }

    }
}
