<aside class="hidden w-64 shrink-0 border-r border-gray-200 bg-white p-5 lg:block">
    <a href="{{ route('books.manage') }}" class="flex items-center gap-3 px-2 text-xl font-bold text-gray-900">
        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-600 text-white">L</span>
        LMS Admin
    </a>
    <p class="mt-8 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Library</p>
    <nav class="mt-3 space-y-1">
        <a href="{{ route('books.manage') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('books.manage') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">Manage books</a>
        <a href="{{ route('books.create') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold {{ request()->routeIs('books.create') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">Add a book</a>
        <a href="{{ route('books.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100">View catalog</a>
        <a href="{{ route('payments.index') }}" class="block rounded-lg px-3 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100">Payments</a>
    </nav>
    <div class="mt-10 border-t border-gray-100 pt-5">
        <p class="px-3 text-sm font-medium text-gray-700">{{ auth()->user()->name }}</p>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button class="w-full rounded-lg px-3 py-2 text-left text-sm font-semibold text-red-600 hover:bg-red-50">Sign out</button>
        </form>
    </div>
</aside>
