<?php

namespace App\Http\Controllers;

use App\Jobs\IncreaseBookCopySoldJob;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookSalesController extends Controller
{
    public function store(Request $request, Book $book)
    {
        IncreaseBookCopySoldJob::dispatch($book);
        return redirect('/show');
    }
}
