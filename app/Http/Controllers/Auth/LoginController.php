<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/user/dashboard';
    
      protected function redirectTo()
    {
        $role = Auth::user()->role;
        if($role == User::ROLE_USER){
            return route('user.dashboard');
        }elseif($role == User::ROLE_MABINO){
            return route('admin.dashboard');
        }else{
            Auth::logout();
            return "/login";
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*override*/
    public function username()
    {
        return 'mobile';
    }


    protected function authenticated($request,$user){
        if($user->role === 3){
            return redirect()->intended('/admin/dashboard'); //redirect to admin panel
        }

        return redirect()->intended('/user/dashboard'); //redirect to standard user homepage
    }

}
