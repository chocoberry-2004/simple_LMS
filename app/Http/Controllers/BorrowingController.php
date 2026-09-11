<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Http\Requests\StoreBorrowingRequest;
use App\Http\Requests\UpdateBorrowingRequest;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $borrowings = Borrowing::with(['book', 'member'])->latest()->paginate(10);
        return view('pages.borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($book)
    {
        //
        $book = \App\Models\Book::findOrFail($book);
        if(Auth::user()?->role !== 'member') {
            abort(403, 'Unauthorized action.');
        }

        return view('pages.borrowing.create', compact('book'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBorrowingRequest $request)
    {
        if(Auth::user()?->role !== 'member') {
            abort(403, 'Unauthorized action.');
        }

        $member = Auth::user()->member;
        abort_unless($member, 403, 'Member profile not found.');

        $borrowing = Borrowing::create([
            ...$request->validated(),
            'member_id' => $member->id,
        ]);

        return redirect()->route('payments.create', $borrowing)
            ->with('success', 'Make payment to complete the borrowing process.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBorrowingRequest $request, Borrowing $borrowing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        //
    }
}
