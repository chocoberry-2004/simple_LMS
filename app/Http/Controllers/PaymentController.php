<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Borrowing;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $payments = Payment::with(['borrowing', 'book', 'member.user'])->latest()->paginate(10);
        return view('pages.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Borrowing $borrowing)
    {
        if(Auth::user()?->role !== 'member') {
            abort(403, 'Unauthorized action.');
        }

        abort_unless($borrowing->member?->user_id === Auth::id(), 403);
        abort_if($borrowing->payments()->whereIn('status', ['pending', 'completed'])->exists(), 422,
            'A payment has already been submitted for this borrowing.');

        $borrowing->load('book');
        return view('pages.payments.create', compact('borrowing'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request, Borrowing $borrowing)
    {
        abort_unless($borrowing->member?->user_id === Auth::id(), 403);
        abort_if($borrowing->payments()->whereIn('status', ['pending', 'completed'])->exists(), 422,
            'A payment has already been submitted for this borrowing.');

        $validated = $request->validated();
        $receiptPath = $request->file('receipt')?->store('payment-receipts', 'public');

        Payment::create([
            'member_id' => $borrowing->member_id,
            'book_id' => $borrowing->book_id,
            'borrow_id' => $borrowing->id,
            'amount' => $borrowing->book->price,
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'],
            'receipt_url' => $receiptPath,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('books.show', $borrowing->book)
            ->with('success', 'Payment submitted and awaiting confirmation.');
    }

    public function complete(Payment $payment)
    {
        abort_unless($payment->status === 'pending', 422, 'This payment cannot be completed.');

        $payment->update(['status' => 'completed', 'paid_at' => now()]);
        $payment->borrowing->update(['status' => 'approved']);

        return back()->with('success', 'Payment marked as completed.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
