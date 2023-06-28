<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VacancyMail extends Mailable
{
    use Queueable, SerializesModels;
  
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject($this->details['subject'])
                    ->view('emails.vacancy');
        if(!empty($this->details["attachment"])){
           
            $mail->attach($this->details["attachment"]->getRealPath(), [
                'as' => $this->details["attachment"]->getClientOriginalName(),
                'mime' => $this->details["attachment"]->getMimeType(),
            ]);

        }
        
        
        return $mail;
    }
}
