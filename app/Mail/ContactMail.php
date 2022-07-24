<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->data = $data;
        // dd($this->data['sender']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
         // return $this->view('mail')->with('data', $this->data);
        // return $this->from('administrator@bands.ph')->subject('new review')->view('mail')->with('data', $this->data);
        // return $this->from($this->data->sender)->subject($this->data->title)->view('mail')->with('data', $this->data);
        return $this->from($this->data['sender'])->subject($this->data['title'])->view('mail')->with('data', $this->data);
        //FOR MAILTRAP (WEEK 6)  #SO DAPAT MAILTRAP GAMIT DITO
    }
}
