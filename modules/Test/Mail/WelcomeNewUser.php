<?php

namespace Course\Mail;

use Course\Models\Course;
use Course\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeNewUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The course instance.
     *
     * @var \Course\Models\Course
     */
    public $course;

    /**
     * The student instance.
     *
     * @var \Course\Models\User
     */
    public $student;

    /**
     * Create a new message instance.
     *
     * @param \Course\Models\Course $course
     * @param \Course\Models\User   $student
     * @param string $subject
     */
    public function __construct(Course $course, User $student, $subject = "")
    {
        $this->course = $course;

        $this->student = $student;

        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->from(settings('site_email'))
                    ->view("Test::emails.welcome.welcome");
    }
}
