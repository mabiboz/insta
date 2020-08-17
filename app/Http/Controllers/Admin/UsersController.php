<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campain;
use App\Models\Page;
use App\Models\PageRequest;
use App\Models\Province;
use App\Models\User;
use App\Models\WalletLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function parentAndChild(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);
        if (!$user) {
            exit;
        }
        $parent = $user->reagent;
        $child = $user->reagentUsers;
        $html = view("admin.users.sections.parentAndChild", compact("child", "parent"))->render();
        return response($html);

    }

    public function adminsOfAgent(Request $request)
    {
        $agent_id = $request->id;
        $agent = User::find($agent_id);
        $admins = $agent->reagentUsers;

        $html = view("admin.agents.sections.admins", compact("admins"));
        return response($html);
    }

    public function usersList()
    {
        $users = User::where('role', 1);
        $users = searchItems(['name', 'mobile', 'email', 'address', 'phone', 'city.name'], $users);
        $users = $users->latest()->paginate(15);
        return view('admin.users.all', compact('users'));
    }

    public function agentsList()
    {
        $users = User::where('role', 2);
        $users = searchItems(['name', 'mobile', 'email', 'address', 'phone', 'city.name'], $users);
        $users = $users->latest()->paginate(15);
        return view('admin.agents.all', compact('users'));
    }

    public function changestate(Request $request)
    {
        $userid = $request->id;
        $status = User::find($userid)->status;
        if ($status == 0) {
            $user = User::find($userid)->update(['status' => User::ACTIVE]);
            if ($user) {
                return 'active';

            }
            return 'error';
        } else {
            $user = User::find($userid)->update(['status' => User::INACTIVE]);
            if ($user) {
                return 'inactive';

            }
            return 'error';
        }

    }


    public function campainList($id)
    {
        $user = User::find($id);
        $campains = $user->campains;
        if (count($campains)) {
            return view('admin.users.sections.campainsList', compact('campains'));
        }
        return "هیچ کمپینی یافت نشد !";

    }


    public function getCampainPagesAjax($id, $userid)
    {
        $user = User::find($userid);

        $campain = Campain::find($id);

        $userCampainsID = $user->campains()->pluck("id")->toArray();
        if (!$campain or !in_array($id, $userCampainsID)) {
            return "Not Found !";
        }
        $pages = $campain->pages;
        $ad = $campain->ads()->first();
        foreach ($pages as $page) {
            $pageRequest = PageRequest::where('ad_id', $ad->id)->where('page_id', $page->id)->first();
            $page->pageRequestStatus = $pageRequest->status;
        }
        return view("user.campains.sections.ajaxViewForPageListAndDetails", compact("pages", "ad"));

    }

    public function payrequestList($id)
    {
        $user = User::find($id);
        $payrequests = $user->payRequests;
        return view('admin.users.sections.payrequestList', compact('payrequests'));

    }

    public function ticketList(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);
        if (!$user) {
            exit;
        }
        $tickets = $user->ticketMessagings()->latest()->get();
        $html = view("admin.users.sections.ticketList", compact("tickets"))->render();
        return response($html);

    }


    public function walletLogs(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);
        if (!$user) {
            exit;
        }
        $walletLogs = $user->walletlogs()->latest()->get();;

        $walletOperations = WalletLog::getWalletOperation();
        $methodsCreateWallet = WalletLog::getMethodWalletCreate();
        $html = view("admin.users.sections.walletLog",compact("walletLogs","walletOperations","methodsCreateWallet"))->render();
        return response()->json($html);


    }

    public function edit(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);
        if (!$user) {
            exit;
        }
        $educationLevels = User::getEducationLevel();
        $allState = Province::all();
        $html = view("admin.users.sections.editForm", compact("user", "educationLevels", "allState"))->render();
        return response($html);
    }

    public function update(Request $request, User $user)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'phone' => 'required|string',
            'address' => 'required|string',
            'birthday' => 'required|string',
            'education_level' => 'required',
            'sex' => 'required',
        ]);

        $newData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birthday' => $request->birthday,
            'education_level' => $request->education_level,
            'sex' => $request->sex,
        ];

        if ($request->filled("password")) {
            $newData['password'] = bcrypt($request->password);
        }

        $resultUpdated = $user->update($newData);
        if ($resultUpdated) {
            flash_message("کاربر با موفقیت به روز رسانی شد !", 'success');
        } else {
            flash_message("متاسفانه مشکلی رخ داده ! لطفا چند لحظه بعد تلاش کنید .", 'danger');
        }
        return back();
    }

    public function pages(Request $request)
    {
        $user_id = $request->id;
        $user = User::find($user_id);
        if (!$user) {
            exit;
        }
        $pages = $user->pages;
        $ageContacts = Page::getContactAge();
        $sexContact = Page::getSexPage();
        $html = view("admin.users.sections.pages", compact('pages', 'ageContacts', 'sexContact'));
        return response($html);
    }


}
