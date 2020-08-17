<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExcelsController extends Controller
{
    public function users()
    {
        $users = \App\Models\User::all();
        foreach ($users as $user){
            $user->mobile = EnFormat($user->mobile);
        }
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($users, ['mobile' => 'mobile'])->download();
    }
    public function pageOwners()
    {
        $users = \App\Models\User::where("is_admin",1)->get();
        foreach ($users as $user){
            $user->mobile = EnFormat($user->mobile);
        }
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($users, ['mobile' => 'mobile'])->download();
    }

    public function agents()
    {
        $users = \App\Models\User::where("role",User::ROLE_AGENT)->get();
        foreach ($users as $user){
            $user->mobile = EnFormat($user->mobile);
        }
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($users, ['mobile' => 'mobile'])->download();
    }

    public function PageOwnerWithoutDetail()
    {
        $users = \App\Models\User::where ("role",User::ROLE_AGENT)->whereHas("pages",function ($q){
            $q->doesntHave("pagedetail");
        })->get();

        foreach ($users as $user){
            $user->mobile = EnFormat($user->mobile);
        }
        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($users, ['mobile' => 'mobile'])->download();
    }

}
