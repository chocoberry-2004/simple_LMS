<x-public-layout>
    <form action="{{ route('books.borrow.store') }}" method="POST" class="mx-auto mt-10 max-w-2xl space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        <div class="">
            <label for="">Book ID</label>
            <input type="number" name="book_id" id="" value="{{ $book->id}}" readonly>

            @error('book_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="">
            <label for="">Borrow Date</label>
            <input type="date" name="borrowed_at" id="" value="{{ old('borrowed_at', now()->toDateString()) }}" required>

            @error('borrowed_at')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="">
            <label for="">Return Date</label>
            <input type="date" name="due_date" id="" value="{{ old('due_date') }}" required>

            @error('due_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Submit Borrowing</button>
    </form> 

</x-public-layout>
