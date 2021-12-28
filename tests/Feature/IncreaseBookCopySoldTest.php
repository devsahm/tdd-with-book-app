<?php

namespace Tests\Feature;

use App\Jobs\IncreaseBookCopySoldJob;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncreaseBookCopySoldTest extends TestCase
{
    use RefreshDatabase;

   public function test_it_increase_copies_sold()
   {
      $user = User::factory()->create();
      $this->actingAs($user);
      $book = $user->books()->save(Book::factory()->make());
      //confirm the copy sold is first 0
      $this->assertEquals(0,  $book->copies_sold);

      //Execute the job
      IncreaseBookCopySoldJob::dispatch($book);

      //confirms the copy sold amount increase
      $book->refresh();
      $this->assertEquals(1, $book->copies_sold);

   }
}
