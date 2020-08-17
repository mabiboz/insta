<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TutorialsController extends Controller
{
    public function adminPage()
    {
        return view("");
    }

    public function agent()
    {
        return view("");
    }

    public function user()
    {
        return view("");
    }

    public function publicTutorial()
    {
        return view("user.tutorials.publicTutorial");
    }
}
