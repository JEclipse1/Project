<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use App\User;
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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function redirect()
   {
       return Socialite::driver('google')->redirect();
   }


   public function callback()
   {

       try {


           $googleUser = Socialite::driver('google')->user();
           $existUser = User::where('email',$googleUser->email)->first();


           if($existUser) {
               Auth::loginUsingId($existUser->id);
           }
           else {
               $user = new User;
               $user->name = $googleUser->name;
               $user->email = $googleUser->email;
               $user->password = md5(rand(1,10000));
               $user->save();
               Auth::loginUsingId($user->id);
           }
           return redirect()->to('/home');
       }
       catch (Exception $e) {
           return 'error';
       }
   }
}
