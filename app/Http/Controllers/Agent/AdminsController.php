<?php

namespace App\Http\Controllers\Agent;

use App\Models\PageRequest;
use App\Models\Province;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminsController extends Controller
{
    public function index()
    {
        $ownerAgent = Auth::user();
        $users = $ownerAgent->reagentUsers;
        return view("agent.admin.index", compact("users"));

    }

    public function create()
    {
        $educationLevels = User::getEducationLevel();
        $allState = Province::all();
        return view("agent.admin.create", compact("educationLevels", "allState"));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'mobile' => 'required|string|max:11|min:10|unique:users',
            'phone' => 'required|string',
            'address' => 'required|string',
            'birthday' => 'required|string',
            'city' => 'required',
            'education_level' => 'required',
            'sex' => 'required',
            'state' => 'required',
        ]);

        $newAdmin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'phone' => $request->phone,
            'status' => User::ACTIVE,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'city_id' => $request->city,
            'education_level' => $request->education_level,
            'sex' => $request->sex,
            "verify" => User::VERIFIED_AND_ACCEPT_RULE,
            "is_admin" => 1,
            "reagent_id" => Auth::user()->id,
            'activation_code' => rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9),
            'password' => bcrypt($request->password),
        ]);

        if ($newAdmin) {
            Wallet::create([
                "user_id" => $newAdmin->id,
                "sum" => 0,
            ]);
            flash_message("ادمین با موفقیت ثبت شد !", "success");

        } else {
            flash_message("مشکلی رخ داده !", "danger");
        }

        return back();


    }


    /*get city*/
    public function getCity(Request $request)
    {
        $stateID = $request->stateID;
        $state = Province::find($stateID);
        if (!$state) {
            exit;
        }
        $allCity = $state->city;
        $allCity = $allCity->pluck('name', 'id');
        return response()->json($allCity);

    }

    public function reportAct(Request $request)
    {
        $admin_id = $request->id;
        $admin = User::find($admin_id);
        if (!$admin) {
            exit;
        }

        $adminPages = $admin->pages;


        foreach ($adminPages as $page) {


            $pageRequests[$page->id] = $page->pageRequest()->where('status', PageRequest::ACCEPTED)
                ->whereHas('statistics', function ($q) {
                    $q->where('end_work', 1);
                })
                ->get();
        }

        $html = view("agent.admin.sections.reportAct", compact("pageRequests"))->render();
        return response($html);


    }


}
