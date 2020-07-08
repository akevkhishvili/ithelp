<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewCase extends Mailable
{
    use Queueable, SerializesModels;

    public $fromLastName;
    public $mailSubject;
    public $fromFirstName;
    public $room;
    public $phone;
    public $caseText;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fromLastName,$mailSubject,$fromFirstName,$room,$phone,$caseText)
    {
        $this->fromLastName = $fromLastName;
        $this->mailSubject = $mailSubject;
        $this->fromFirstName = $fromFirstName;
        $this->room = $room;
        $this->phone = $phone;
        $this->caseText = $caseText;
        //dd($mailSubject);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = session()->pull('subject');
        return $this->subject($subject)->view('it.newCaseMail');
    }
}
