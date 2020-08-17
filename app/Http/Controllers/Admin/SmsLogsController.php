<?php

namespace App\Http\Controllers\Admin;

use App\Models\SmsLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmsLogsController extends Controller
{
    public function index()
    {
        $sms = SmsLog::query();
        $sms = searchItems(['mobile'], $sms);
        $sms = $sms->latest()->paginate(20);
        return view("admin.sms.index", compact("sms"));

    }

    public function verify()
    {

        $sms = SmsLog::where("type", SmsLog::USER_VERIFY);
        $sms = searchItems(['mobile'], $sms);
        $sms = $sms->latest()->paginate(20);
        return view("admin.sms.index", compact("sms"));
    }
}
