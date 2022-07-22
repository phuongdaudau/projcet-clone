<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    protected $redirectTo = '/';


    protected function guard()
    {
        return Auth::guard('web');
    }


    protected function broker()
    {
        return Password::broker('members');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset');
    }

    public function requestPassword(Request $request)
    {
        $email = $request->only('email');
        $member = Member::where('email', $email)->first();
        if(!$member){
            return redirect()->back()->with('error', 'email');
        }
        $details = [
            'title' => 'Reset Password',
            'url' => route('reset_password_member',  ['token' => base64_encode(
                json_encode([
                    'id' => $member->id
                ])
            )])
        ];
        Mail::to($email)->send(new \App\Mail\Mail($details));
        return redirect()->route('login')->with('success', 'email');
    }

    public function resetPassword($token)
    {
        $memberId = json_decode(base64_decode($token));
        return view('auth.update')->with(['id' => $memberId->id]);
    }

    public function resetPasswordMember()
    {
        Member::find(request()->id)->update([
            'password' => Hash::make(request()->password)
        ]);
        return redirect()->route('login')->with('success', 'email');
    }
}
