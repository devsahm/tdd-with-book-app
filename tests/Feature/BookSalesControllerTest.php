<?php

namespace Tests\Feature;

use App\Jobs\IncreaseBookCopySoldJob;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class BookSalesControllerTest extends TestCase
{
  use RefreshDatabase;

    public function test_user_can_increase_copies_sold()
    {
        $this->withoutExceptionHandling();
        Bus::fake();
        //create user
       $user = User::factory()->create();

       //authenticate user
       $this->actingAs($user);

       //Create a books
       $book = $user->books()->save(Book::factory()->make());

       //Call the post request to create increment the book count
       $response = $this->post("/book/{$book->id}/sales");
       Bus::assertDispatched(IncreaseBookCopySoldJob::class, function($job) use($book) {
            return $job->book->id === $book->id;
       });

       $response->assertStatus(302);

       $response->assertRedirect('/show');
    }

}
