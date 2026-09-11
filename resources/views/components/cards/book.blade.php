@props(['book'])

<article class="group h-full overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
    <a href="{{ route('books.show', $book) }}" class="block">
        <div class="relative flex h-52 items-center justify-center overflow-hidden bg-gradient-to-br from-blue-100 via-indigo-50 to-violet-100">
            @if ($book->cover_image)
                <img src="{{ Str::startsWith($book->cover_image, ['http://', 'https://']) ? $book->cover_image : Storage::url($book->cover_image) }}" alt="Cover for {{ $book->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
            @else
                <svg class="h-16 w-16 text-blue-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v19H6.5A2.5 2.5 0 0 1 4 18.5v-14A2.5 2.5 0 0 1 6.5 2Z"/></svg>
            @endif
            <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-blue-700 shadow-sm">{{ $book->category?->name ?? 'Uncategorized' }}</span>
        </div>
        <div class="p-5">
            <h2 class="line-clamp-2 text-lg font-bold text-gray-900 group-hover:text-blue-700">{{ $book->title }}</h2>
            <p class="mt-1 text-sm text-gray-500">by {{ $book->author?->name ?? 'Unknown author' }}</p>
            @if ($book->description)
                <p class="mt-3 line-clamp-2 text-sm leading-6 text-gray-600">{{ $book->description }}</p>
            @endif
        </div>

        <div class="p-5">
            <a href="{{route('books.show', $book)}}">View Details</a>
        </div>
        
    </a>
</article>
