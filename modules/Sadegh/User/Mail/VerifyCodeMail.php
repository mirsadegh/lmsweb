<?php

namespace Sadegh\User\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Sadegh\User\Models\User;

class VerifyCodeMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */

    public $code;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct( $code)
    {
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('User::mails.verify-mail')
            ->subject('وب آموز | کد فعالسازی');
    }
}
