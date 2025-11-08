<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Display a listing of the books
    public function index(Request $request)
    {
        $search = $request->input('search');
        $books = Book::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%");
        })->paginate(10);

        return view('books.index', compact('books', 'search'));
    }

    // Store a newly created book in storage
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    // Display the specified book
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    // Show the form for creating a new book
    public function create()
    {
        return view('books.create');
    }

    // Show the form for editing the specified book
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    // Update the specified book in storage
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }


        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    // Remove the specified book from storage
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
