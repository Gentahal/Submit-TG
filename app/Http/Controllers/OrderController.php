<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Menu;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create(Menu $menu)
    {
        return view('customer.create_order', compact('menu'));
    }

    public function store(Request $request, Menu $menu)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'delivery_date' => 'required|date|after:today',
        ]);

        $order = Order::create([
            'customer_id' => auth()->id(),
            'merchant_id' => $menu->merchant_id,
            'menu_id' => $menu->id,
            'quantity' => $request->quantity,
            'total_price' => $menu->price * $request->quantity,
            'delivery_date' => $request->delivery_date,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.orders')->with('success', 'Order placed successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function customerOrders()
    {
        $orders = auth()->user()->orders()->with('menu.merchant')->get();
        return view('customer.orders', compact('orders'));
    }

    public function merchantOrders()
    {
        $orders = auth()->user()->merchantOrders()->with('menu', 'customer')->get();
        return view('merchant.orders', compact('orders'));
    }

    public function updateStatus(Order $order, Request $request)
    {
        $request->validate([
            'status' => 'required|in:confirmed,preparing,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully');
    }
}