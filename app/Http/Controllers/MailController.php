<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\ContactMail;
use Redirect;
use Mail;

class MailController extends Controller
{
    //
    public function contact(Request $request) {
        // $data = new \stdClass();
     //    $data->sender = $request->sender;
     //    $data->title = $request->title;
     //    $data->body = $request->body;
    $data = array(
            'sender'   =>  $request->sender,
            'title'   =>  $request->title,
            'body'   =>   $request->body
            
        );
        //dd($data);
        Mail::to('administrator@bands.com.ph')->send(new ContactMail($data));
        return Redirect::back()->with('success','Email sent successfully!');
}
}
