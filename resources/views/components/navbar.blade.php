<nav class="bg-white/95 backdrop-blur-sm fixed w-full z-30 top-0 start-0 border-b border-gray-200/80 shadow-sm">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-5 py-3.5">
        <a href="{{ url('/') }}" class="flex items-center space-x-2.5 rtl:space-x-reverse">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-lg font-bold text-white">L</span>
            <span class="self-center text-xl font-semibold text-gray-900 tracking-tight whitespace-nowrap">LMS</span>
        </a>

        <button data-collapse-toggle="navbar-dropdown" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-300 transition"
            aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
            </svg>
        </button>

        <div class="hidden w-full md:block md:w-auto" id="navbar-dropdown">
            <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-200 rounded-xl bg-white md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent shadow-sm md:shadow-none">
                <li>
                    <a href="{{ url('/') }}" class="block py-2.5 px-3 {{ request()->is('/') ? 'text-white bg-blue-600 md:bg-transparent md:text-blue-700 md:font-semibold' : 'text-gray-700' }} rounded-lg md:p-0 transition">Home</a>
                </li>
                <li>
                    <a href="{{ route('books.index') }}" class="block py-2.5 px-3 {{ request()->routeIs('books.*') ? 'text-white bg-blue-600 md:bg-transparent md:text-blue-700 md:font-semibold' : 'text-gray-700' }} rounded-lg md:p-0 transition">Books</a>
                </li>
                @auth
                    @if (auth()->user()?->role === 'admin')
                        <li>
                            <a href="{{ route('books.manage') }}" class="block py-2.5 px-3 {{ request()->routeIs('books.manage') ? 'text-white bg-blue-600 md:bg-transparent md:text-blue-700 md:font-semibold' : 'text-gray-700' }} rounded-lg md:p-0 transition">Dashboard</a>
                        </li>                        
                    @else
                        <li><a href="{{ route('dashboard') }}" class="block py-2.5 px-3 text-gray-700 rounded-lg md:p-0 md:hover:text-blue-700 transition">Dashboard</a></li>
                    @endif
                
                @else
                    <li><a href="{{ route('login') }}" class="block py-2.5 px-3 text-gray-700 rounded-lg md:p-0 md:hover:text-blue-700 transition">Sign in</a></li>
                    <li><a href="{{ route('register') }}" class="block py-2.5 px-3 text-gray-700 rounded-lg md:p-0 md:hover:text-blue-700 transition">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
