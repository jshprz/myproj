<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\buildcommerce\Repository\StoreRepositoryInterface;
use App\buildcommerce\Models\StoreUsers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(StoreUsers $store_users, StoreRepositoryInterface $store)
    {
        $this->middleware('guest')->except('logout');
        $this->store_users = $store_users;
        $this->store = $store;
    }

    public function dummy()
    {
        return view("welcome");
    }

    public function index(Request $request)
    {
        $private_ip = $request->server('SERVER_ADDR');
        $data = $this->store->getStoreByPrivateIp($private_ip);
        if($data)
        {
        return view("auth.login",compact('data'));
        }
        else
        {
            return view('error-page.404');
        }
    }
    protected function validator(array $data)
    {
        return Validator::make($data,[
            'email' => 'required|string|email|max:255',
            'password' => 'required|min:6',
        ]);
    }
    protected function Login(Request $request)
    {
        if(!Auth::check())
        {
            $input = $request->all();
            $validator = $this->validator($input);
            $validator->validate();

            $private_ip = $request->server('SERVER_ADDR');
            $store_data = $this->store->getStoreByPrivateIp($private_ip);
            if($validator->passes())
            {
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'confirmed' => 1, 'store_id' => $store_data->id]))
                {
            
                    return redirect()->route('auth.shops');                   
                }
                else
                {
                    return back()->with('flashError','Wrong credential please try again');
                }
            
            }
            else
            {
                return back()->with('flashError',$validator->errors);
            }
        }
        else
        {
            return back()->with('flashError','asdasd');
        }
    }

    protected function Logout()
    {
        Auth::logout();
        Session::flush();
    }
}
