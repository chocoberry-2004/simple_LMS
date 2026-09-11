<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = \App\Models\Category::all();

        $authors = \App\Models\Author::all();

        $books = Book::with(['author', 'category'])

        ->when(request('search'), function ($query, $search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhereHas('author', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        })

        ->when(request('category'), function ($query, $category) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            });
        })

        ->when(request('author'), function ($query, $author) {
            $query->where('author_id', $author);
        })
        
        ->latest()->paginate(12)->withQueryString();
        return view('pages.books.index', compact('books' ,'categories', 'authors'));
    }

    public function manage()
    {
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $categories = \App\Models\Category::all();

        $authors = \App\Models\Author::all();

        $books = Book::with(['author', 'category'])

        ->when(request('search'), function ($query, $search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhereHas('author', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        })

        ->when(request('category'), function ($query, $category) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('id', $category);
            });
        })

        ->when(request('author'), function ($query, $author) {
            $query->where('author_id', $author);
        })
        
        ->latest()->paginate(20)->withQueryString();
        return view('pages.books.manage', compact('books' ,'categories', 'authors'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $categories = \App\Models\Category::all();
        $authors = \App\Models\Author::all();
        return view('pages.books.create', compact('categories', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        //
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validated();
        $validatedData['book_file'] = $request->file('book_file')->store('books', 'local');

        if ($request->hasFile('cover_image')) {
            $validatedData['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        $book = Book::create($validatedData);
        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
        $book->load('author', 'category');
        return view('pages.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $categories = \App\Models\Category::all();
        $authors = \App\Models\Author::all();
        return view('pages.books.edit', compact('book', 'categories', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validated();

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($book->cover_image);
            $validatedData['cover_image'] = $request->file('cover_image')->store('book-covers', 'public');
        }

        if ($request->hasFile('book_file')) {
            Storage::disk('local')->delete($book->book_file);
            $validatedData['book_file'] = $request->file('book_file')->store('books', 'local');
        }

        $book->update($validatedData);
        return redirect()->route('books.index')->with('success', 'Book updated successfully.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($book->cover_image);
        Storage::disk('local')->delete($book->book_file);
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    public function read(Book $book)
    {
        abort_unless($book->canBeReadBy(Auth::user()), 403, 'You need an active borrowing to read this book.');
        abort_unless(Storage::disk('local')->exists($book->book_file), 404, 'Book file not found.');

        return Storage::disk('local')->response(
            $book->book_file,
            basename($book->book_file)
        );
    }

    public function borrow(Book $book)
    {
        abort_unless(Auth::user()?->role === 'member', 403);

        if (! $book->isAvailable()) {
            return back()->with('error', 'This book is currently on loan.');
        }

        $member = Member::firstOrCreate(['user_id' => Auth::id()]);
        $book->borrowings()->create([
            'member_id' => $member->id,
            'borrowed_at' => today(),
            'due_date' => today()->addDays(14),
        ]);

        return redirect()->route('books.show', $book)
            ->with('success', 'Book borrowed. You can read it for 14 days.');
    }
}
