
<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    

                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold mb-4">Manage Books</h1>

                        @if (auth()->user()?->role === 'admin')
                            <a href="{{ route('books.create') }}" class="inline-flex items-center justify-center rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200">Add a book</a>
                        @endif
                    </div>

                    <div class="my-5">
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
                                    <a href="{{ route('books.manage') }}" class="rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-200">Reset</a>
                                </div>
                            </div>  
                        </form>
                    </div>

                    <div class="">
                        <table>
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 text-left">Title</th>
                                    <th class="px-4 py-2 text-left">Author</th>
                                    <th class="px-4 py-2 text-left">Category</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $book)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $book->title }}</td>
                                        <td class="px-4 py-2">{{ $book->author->name }}</td>
                                        <td class="px-4 py-2">{{ $book->category->name }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('books.edit', $book) }}" class="text-blue-600 hover:underline">Edit</a>

                                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this book?')" class="text-red-600 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-admin-layout>
