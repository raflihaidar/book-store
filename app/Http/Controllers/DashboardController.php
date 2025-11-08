<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::paginate(12);
        $isAdmin = auth()->check() && auth()->user()->role->name === 'admin';

        return view('dashboard', compact('books', 'isAdmin'));
    }
}
