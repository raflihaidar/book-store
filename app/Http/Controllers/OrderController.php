<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.index', ['orders' => $orders]);
    }

    public function indexAdmin()
    {
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('orders.admin-index', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0.01',
        ]);

        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('book')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Cart is empty');
        }

        $total = $cartItems->sum(fn($item) => $item->book->price * $item->quantity);

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $total,
            'amount_paid' => $request->amount_paid,
            'status' => 'completed',
            'order_date' => now(),
        ]);

        // Store order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'book_id' => $item->book_id,
                'quantity' => $item->quantity,
                'price' => $item->book->price,
            ]);
        }

        // Clear cart
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('orders.index')->with('success', __('Order completed successfully!'));
    }

    public function show(Order $order)
    {
        $order->load('items.book');

        return view('orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', __('Order deleted successfully!'));
    }
}
