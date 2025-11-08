<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('book')
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $book = Book::find($request->book_id);

        if ($book->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak cukup');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $request->quantity;
            if ($book->stock < $newQuantity) {
                return redirect()->back()->with('error', 'Stok tidak cukup');
            }
            $cart->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'book_id' => $book->id,
                'quantity' => $request->quantity,
            ]);
        }

        $book->decrement('stock', $request->quantity);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke keranjang');
    }

    public function remove(Cart $cart)
    {
        $book = $cart->book;
        $book->increment('stock', $cart->quantity);
        $cart->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus dari keranjang');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $book = $cart->book;
        $quantityDifference = $request->quantity - $cart->quantity;

        if ($quantityDifference > 0 && $book->stock < $quantityDifference) {
            return redirect()->back()->with('error', 'Stok tidak cukup');
        }

        $cart->update(['quantity' => $request->quantity]);

        if ($quantityDifference > 0) {
            $book->decrement('stock', $quantityDifference);
        } else {
            $book->increment('stock', abs($quantityDifference));
        }

        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui');
    }

    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())
            ->with('book')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });

        return view('checkout.index', compact('cartItems', 'total'));
    }
}
