<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use App\User;

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
    //protected $redirectTo = RouteServiceProvider::HOME;


    protected $redirectAfterLogout = 'auth/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $google2fa = app('pragmarx.google2fa');
        $google2fa_secret = $google2fa->generateSecretKey();

        $qr_image = $google2fa->getQRCodeInline(
            config('app.name'),
            rand(),
            $google2fa_secret
        );

        return view('auth.login', [
            'google2fa_secret' => $google2fa_secret,
            'qr_image' => $qr_image,
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
     
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            
            Auth::logoutOtherDevices($request->password);
            // return $this->authenticated($request);
        }
    
        return redirect("login")->withSuccess('Oops! You have entered invalid credentials');
    }

    protected function authenticated($request, $user){

        if($user->hasRole(['Admin', 'Sub-Admin'])){
            return redirect('/dashboard');

        }else if($user->hasRole(['Investor', 'Company'])){

            return redirect('/investor/dashboard');
        } else {
            return redirect('/denied');
        }
    }
    
   
    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }
}
