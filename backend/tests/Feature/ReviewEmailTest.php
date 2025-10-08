<?php

namespace Tests\Feature;

use App\Mail\ReviewSubmitted;
use App\Models\Reviews;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ReviewEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_email_when_review_is_submitted()
    {
        // Arrange: Create a review and fake the mail
        Mail::fake();
        
        $reviewData = [
            'rating' => 5,
            'comments' => 'Excellent service!',
            'is_editable' => true,
        ];

        // Act: Submit the review
        $response = $this->postJson('/api/reviews', $reviewData);

        // Assert: Check that the review was created in the database
        $this->assertDatabaseHas('reviews', $reviewData);

        // Assert: Check that an email was sent
        Mail::assertSent(ReviewSubmitted::class, function ($mail) use ($reviewData) {
            $mail->build(); // Make sure the build method is called to access the review data
            return $mail->review->rating === $reviewData['rating'] &&
                   $mail->review->comments === $reviewData['comments'];
        });

        // Assert: Check the response
        $response->assertStatus(201)
                 ->assertJson(['message' => 'Review submitted successfully']);
    }
}
