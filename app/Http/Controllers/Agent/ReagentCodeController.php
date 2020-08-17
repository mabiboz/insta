<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReagentCodeController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $code = $user->reagent_code;
        return view("agent.reagentCode.index",compact("code"));

    }
}
