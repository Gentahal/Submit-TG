<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        return view('invoice.show', compact('invoice'));
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

    public function generate(Order $order)
    {
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'merchant_id' => $order->merchant_id,
            'total_amount' => $order->total_price,
            'status' => 'unpaid',
        ]);

        return redirect()->route('invoice.show', $invoice);
    }

    public function pay(Invoice $invoice)
    {
        // Implement payment logic here
        $invoice->update(['status' => 'paid']);

        return redirect()->route('invoice.show', $invoice)->with('success', 'Payment successful');
    }

    public function merchantInvoices()
    {
        $invoices = auth()->user()->merchantInvoices()->with('order')->get();
        return view('merchant.invoices', compact('invoices'));
    }

    public function customerInvoices()
    {
        $invoices = auth()->user()->customerInvoices()->with('order')->get();
        return view('customer.invoices', compact('invoices'));
    }
}