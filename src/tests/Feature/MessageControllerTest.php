<?php

// In tests/Feature/MessageControllerTest.php

namespace Tests\Feature;

use App\Models\Feed;
use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_message_successfully()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a feed
        $feed = Feed::factory()->create();

        // Send a POST request to the send route
        $response = $this->post(route('api.messages.send'), [
            'content' => 'Test message content',
            'feed_id' => $feed->id,
        ]);

        // Assert the message was created
        $this->assertDatabaseHas('messages', [
            'content' => 'Test message content',
            'feed_id' => $feed->id,
        ]);

        // Assert the response status
        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Message sent!');
    }

    public function test_send_message_validation_error()
    {
        // Create a user and authenticate
        $user = User::factory()->create();
        $this->actingAs($user);

        // Send a POST request with missing content
        $response = $this->post(route('api.messages.send'), [
            'feed_id' => 1,
        ]);

        // Assert validation errors
        $response->assertSessionHasErrors(['content']);
    }
}
