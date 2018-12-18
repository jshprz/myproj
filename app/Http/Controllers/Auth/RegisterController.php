<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\buildcommerce\Repository\StoreRepositoryInterface;
use App\buildcommerce\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $user, StoreRepositoryInterface $store)
    {
        $this->user = $user;
        $this->store = $store;
        $this->middleware('guest');
    }

    public function index(Request $request)
    {

        $private_ip = $request->server('SERVER_ADDR');
        $data = $this->store->getStoreByPrivateIp($private_ip);
        if($data)
        {
            return view('auth.registration',compact('data'));
        }
        else
        {
            return view('error-page.404');
        }
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function registerBuyer(Request $request)
    {
        $input = $request->all();
        $validator = $this->validator($input);
        $validator->validate();
        if($validator->passes())
        {
            if(!$this->user->registerBuyerAccount($request))
            {
                return back()->with('flashError','There is some error occured please try again!');
            }
            else
            {
                return back()->with('flashSuccess','The confirmation code has been sent to your email please check it out.');
            }
        }
        else
        {
            return back()->with($validator->errors());
        }

    }

    protected function activate($token)
    {
        $user = $this->user->activate($token);
        if(!$user)
        {
            return redirect()->route('guest.user-login')->with('flashError', t('You are not registered with us'));
        }
        else
        {
            return redirect()->route('guest.user-login')->with('flashSuccess', t('Congratulations your account is created and activated'));
        }
    }
}
