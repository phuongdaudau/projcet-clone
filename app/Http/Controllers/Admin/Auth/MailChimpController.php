<?php

namespace App\Http\Controllers\Admin\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MailChimpController extends Controller
{
    public function index(Request $request)
    {
        $listId = env('MAILCHIMP_LIST_ID');

        $mailchimp = new \Mailchimp(env('MAILCHIMP_KEY'));

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

        dd('Campaign send successfully.');
    }
}
