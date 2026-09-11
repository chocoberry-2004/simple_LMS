<x-public-layout>
    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-blue-600">Library catalog</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Find your next great read</h1>
            <p class="mt-2 text-gray-600">Browse {{ $books->count() }} {{ Str::plural('book', $books->count()) }} in our collection.</p>
        </div>
    </div>

    <div class="">
        <form action="" method="GET" class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            @csrf
            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-4">
                    <label for="search" class="sr-only">Search books</label>
                    <input type="text" name="search" id ="search" value="{{ request('search') }}" placeholder="Search books..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 sm:w-auto">
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:gap-4">
                    <label for="category" class="sr-only">Filter by category</label>
                    <select name="category" id="category" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 sm:w-auto">
                        <option value="">All categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <label for="author" class="sr-only">Filter by author</label>
                    <select name="author" id="author" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 sm:w-auto">
                        <option value="">All authors</option>
                        @foreach ($authors as $author)
                            <option value="{{ $author->id }}" @selected(request('author') == $author->id)>{{ $author->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">Filter</button>
                    <a href="{{ route('books.index') }}" class="rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-200">Reset</a>
                </div>
            </div>  
        </form>
    </div>

    @if (session('success'))
        <div class="mt-8 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800" role="status">{{ session('success') }}</div>
    @endif

    @if ($books->isEmpty())
        <div class="mt-10 rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v19H6.5A2.5 2.5 0 0 1 4 18.5v-14A2.5 2.5 0 0 1 6.5 2Z"/></svg>
            <h2 class="mt-4 text-lg font-semibold text-gray-900">The library is empty</h2>
            <p class="mt-1 text-sm text-gray-600">Add the first title to start building the collection.</p>
        </div>
    @else
        <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($books as $book)
                <x-cards.book :book="$book" />
            @endforeach

        </div>

        <div class="flex w-full justify-center mt-10">
            {{$books->links()}}
        </div>
    @endif
</x-public-layout>
