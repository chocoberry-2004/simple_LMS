<x-public-layout>
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('books.show', $book) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">&larr; Back to book</a>
        <div class="mt-4 rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">Library management</p>
            <h1 class="mt-1 text-3xl font-bold text-gray-900">Edit {{ $book->title }}</h1>
            <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data" class="mt-8 space-y-6">
                @csrf
                @method('PUT')
                @include('pages.books.partials.form', ['book' => $book])
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <a href="{{ route('books.show', $book) }}" class="rounded-lg px-4 py-2.5 text-center text-sm font-semibold text-gray-700 hover:bg-gray-100">Cancel</a>
                    <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Update book</button>
                </div>
            </form>
        </div>
    </div>
</x-public-layout>
