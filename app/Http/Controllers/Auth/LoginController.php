<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\MainCart;
use App\Models\Member;
use Illuminate\Support\Facades\Session;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::guard('web')->attempt($credentials)) {
            if (Session::get('Cart') != null){
                $email = $request->only('email');
                $member = Member::where('email', $email)->first();
                foreach (Session::get('Cart')->products as $product_id => $item){
                    $cart = MainCart::create([
                        'product_id' => $product_id,
                        'member_id' => $member->id,
                        'color' => $item['color'],
                        'size' =>$item['size'],
                        'quantity' => $item['quantity']
                    ]);
                }
                $request->Session()->forget('Cart');
            }
            $request->session()->regenerate();
            return redirect()->intended('/');
        } 
    }

    protected function guard()
    {
        return Auth::guard('web');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->intended('/');
    }
}
