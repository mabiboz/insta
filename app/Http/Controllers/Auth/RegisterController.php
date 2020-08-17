<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Province;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $reagent_code = '';
        if (!is_null($data['reagent'])) {
            $reagentItem = User::where("reagent_code",EnFormat($data['reagent']))->first();
            if($reagentItem and $reagentItem instanceof User){
                $reagent_code = $data['reagent'];
            }
        }


        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'mobile' => 'required|string|max:11|min:10|unique:users',
            'phone' => 'nullable|string',
            'address' => 'required|string',
            'birthday' => 'nullable|string',
           
            'education_level' => 'required',
            'sex' => 'required',
          
            'reagent_id' => 'nullable',
            'reagent' => 'nullable|'.Rule::in([$reagent_code]),


        ],[
            'reagent.in' =>'کد معرف اشتباه است .',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $reagent_id = 0;
        if (!is_null($data['reagent'])) {
            $reagentItem = User::where("reagent_code",$data['reagent'])->first();
            if($reagentItem and $reagentItem instanceof User){
                $reagent_id = $reagentItem->id;
            }
        }

        $newUser = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => EnFormat($data['mobile']),
            'phone' => $data['phone'],
            'status' => User::ACTIVE,
            'address' => $data['address'],
            'birthday' => $data['birthday'],
            // 'city_id' => $data['city'],
            'education_level' => $data['education_level'],
            'sex' => $data['sex'],
            'activation_code' => rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9),
            'reagent_id' => $reagent_id ,
            'password' => bcrypt($data['password']),
        ]);

        Wallet::create([
            "user_id" => $newUser->id,
            "sum" => 0,
        ]);
        return $newUser;
    }


    /*override */
    public function showRegistrationForm()
    {
        $educationLevels = User::getEducationLevel();
        $allState = Province::all();
        return view('auth.register', compact("educationLevels", "allState"));
    }

    protected function registered(Request $request, $user)
    {
        $activation_code = $user->activation_code;
        $mobile = $user->mobile;
        sendActivationCode(EnFormat($mobile), $activation_code);


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


}
