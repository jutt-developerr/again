<?php

namespace App\Jobs\Notifications\Auth\Registration;

use App\Jobs\Notifications\BaseNotification;
use App\Models\User;
use Illuminate\Mail\Message;

class ContactusNotification extends BaseNotification
{
    /**
     * The registered user.
     *
     * @var User
     */
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendContactusEMail();
    }
    /**
     * Send the Contactus (welcome) email.
     */
    protected function sendContactusEmail()
    {
        //$data = ['data' => $this->data];
        $data=$this->data; 

        $this->mailer()
            ->send('email.auth.contactus.contactusmail', $data, function (Message $message) {
                //$message->to($this->user->email);
                $message->to(env('MAIL_FROM_ADDRESS'));
                $message->subject('Welcome to Tag Your Taxi');
            });
    }
}
