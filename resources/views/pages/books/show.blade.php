<x-public-layout>
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('books.index') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800">&larr; Back to catalog</a>

        @if (session('success'))
            <div class="mt-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800" role="status">{{ session('success') }}</div>
        @endif

        <article class="mt-5 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm md:grid md:grid-cols-[minmax(240px,0.8fr)_minmax(0,1.5fr)]">
            <div class="flex min-h-80 items-center justify-center bg-gradient-to-br from-blue-100 via-indigo-50 to-violet-100 p-8">
                @if ($book->cover_image)
                    <img src="{{ Str::startsWith($book->cover_image, ['http://', 'https://']) ? $book->cover_image : Storage::url($book->cover_image) }}" alt="Cover for {{ $book->title }}" class="max-h-96 w-auto rounded-lg object-contain shadow-xl">
                @else
                    <svg class="h-24 w-24 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v19H6.5A2.5 2.5 0 0 1 4 18.5v-14A2.5 2.5 0 0 1 6.5 2Z"/></svg>
                @endif
            </div>
            <div class="p-7 sm:p-10">
                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ $book->category?->name ?? 'Uncategorized' }}</span>
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $book->title }}</h1>
                <p class="mt-3 text-lg text-gray-600">by <span class="font-semibold text-gray-800">{{ $book->author?->name ?? 'Unknown author' }}</span></p>
                <div class="mt-7 border-t border-gray-100 pt-6">
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-500">About this book</h2>
                    <p class="mt-3 whitespace-pre-line leading-7 text-gray-700">{{ $book->description ?: 'No description has been added for this book yet.' }}</p>
                </div>
                @auth
                    @if ($book->canBeReadBy(auth()->user()))
                        <a href="{{ route('books.read', $book) }}" target="_blank" rel="noopener" class="mt-6 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Read book</a>
                    @elseif (auth()->user()->role === 'member')
                        {{-- <form action="{{ route('books.borrow', $book) }}" method="POST" class="mt-6">
                            @csrf
                            <button type="submit" @disabled(! $book->isAvailable()) class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-gray-300">
                                {{ $book->isAvailable() ? 'Borrow for 14 days' : 'Currently on loan' }}
                            </button>
                        </form> --}}

                        <a href="{{ route('books.borrow', $book) }}" class="mt-6 inline-flex items-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 ">
                            Borrow Book
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="mt-6 inline-flex rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Sign in to borrow</a>
                @endauth
                @if (auth()->user()?->role === 'admin')
                    <div class="mt-8 flex flex-wrap gap-3 border-t border-gray-100 pt-6">
                        <a href="{{ route('books.edit', $book) }}" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Edit book</a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Delete {{ addslashes($book->title) }}? This cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-red-200 px-4 py-2.5 text-sm font-semibold text-red-700 hover:bg-red-50">Delete book</button>
                        </form>
                    </div>
                @endif

            </div>
        </article>
    </div>
</x-public-layout>
