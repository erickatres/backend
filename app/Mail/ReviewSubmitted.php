<?php

namespace App\Mail;

use App\Models\Reviews;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $review;

    /**
     * Create a new message instance.
     *
     * @param Reviews $review
     * @return void
     */
    public function __construct(Reviews $review)
    {
        // Ensure that the review object is assigned correctly
        $this->review = $review;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Review Submitted') // Set the email subject
                    ->view('emails.review-submitted') // Specify the view for the email content
                    ->with([ // Pass the review object to the view
                        'review' => $this->review,
                    ]);
    }
}
