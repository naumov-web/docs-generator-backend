<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class WelcomeEmail
 * @package App\Mail
 */
final class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User instance
     * @var User
     */
    private User $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get subject for email
     *
     * @return string
     */
    private function getSubject(): string
    {
        return __('messages.welcome_to_docs_generator');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        $this->to($this->user->email);
        $this->subject($this->getSubject());

        return $this->view('emails.user_welcome');
    }
}
