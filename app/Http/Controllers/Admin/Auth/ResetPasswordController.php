<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Foundation\Auth\ResetsPasswords;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

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

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin/';


    protected function guard()
    {
        return Auth::guard('admin');
    }


    protected function broker()
    {
        return Password::broker('admins');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('admin.auth.passwords.reset');
    }

    public function requestPassword(Request $request)
    {
        $email = $request->only('email');
        $admin = Admin::where('email', $email)->first();
        if(!$admin){
            return redirect()->back()->with('error', 'email');
        }
        // $details = [
        //     'title' => 'Reset Password',
        //     'url' => route('admin.reset_password_admin',  ['token' => base64_encode(
        //         json_encode([
        //             'id' => $admin->id
        //         ])
        //     )])
        // ];
        // Mail::to($email)->send(new \App\Mail\Mail($details));
        $listId = env('MAILCHIMP_LIST_ID');

        $mailchimp = new \Mailchimp(env('MAILCHIMP_API_KEY'));

        $campaign = $mailchimp->campaigns->create('regular', [
            'list_id' => $listId,
            'subject' => 'Example Mail',
            'from_email' => 'phuongdauduaim@gmail.com',
            'from_name' => 'Phuong',
            'to_name' => 'Admin'

        ], [
            'html' => $request->input('content'),
            'text' => strip_tags($request->input('content'))
        ]);

        //Send campaign
        $mailchimp->campaigns->send($campaign['id']);
        return redirect()->route('admin.login')->with('success', 'email');

    }

    public function resetPassword($token)
    {
        $adminId = json_decode(base64_decode($token));
        return view('admin.auth.register')->with(['id' => $adminId->id]);
    }

    public function resetPasswordAdmin()
    {
        Admin::find(request()->id)->update([
            'password' => Hash::make(request()->password)
        ]);
        return redirect()->route('admin.login')->with('success', 'email');
    }
}
