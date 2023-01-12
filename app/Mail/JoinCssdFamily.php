<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JoinCssdFamily extends Mailable
{
    use Queueable, SerializesModels;

    public $userDetails, $url, $createdBy, $userTypeName;

    /**
     * Create a new message instance.
     *
     * @param $userDetails
     * @param $createdBy
     * @param $url
     * @param $userTypeName
     */
    public function __construct($userDetails, $createdBy, $url, $userTypeName)
    {
        $this->userDetails = $userDetails;
        $this->createdBy = $createdBy;
        $this->url = $url;
        $this->userTypeName = $userTypeName;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.join-cssd-family');
    }

}
