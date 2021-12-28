<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use App\Notifications\BookCreatedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_index_page_is_rendered_properly()
    {
        $this->withoutExceptionHandling();
        //create user, go to the book route and assert it opens
      
       $user = User::factory()->create();
       $this->actingAs($user);
       $response = $this->get('/books');
       $response->assertStatus(200);
    }

    public function test_user_can_create_book()
    {
        $this->withoutExceptionHandling();
        Notification::fake();
        //create a user, then a user crreates a book, the the user is redirected to /show
        $user = User::factory()->create();
        $this->actingAs($user);

       $response= $this->post('/books', [
            'name' => 'The Army',
            'price' => 20
        ]);

        $response->assertStatus(302);

        $book = Book::first();

        $this->assertEquals(1, Book::count());
        $this->assertEquals('The Army', $book->name);
        $this->assertEquals(20, $book->price);
        $this->assertEquals(0, $book->copies_sold);
        $this->assertEquals($user->id, $book->user->id);
        $this->assertInstanceOf(User::class, $book->user);
        Notification::assertSentTo($user, BookCreatedNotification::class);
        $response->assertRedirect('/show');
    }

}
