<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Notifications\BookCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    public function show()
    {
        # code...
    }

    public function index()
    {
        # code...
    }

    public function store(Request $request)
    {

        $book = Book::create([
            'name' => $request->name,
            'price' => $request->price,
            'copies_sold' => 0, 
            'user_id' => Auth::user()->id
        ]);
        $book->user->notify(new BookCreatedNotification());
        return redirect('/show');
    }
}
