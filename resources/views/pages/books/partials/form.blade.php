@php($value = fn ($field) => old($field, $book?->{$field}))

<div>
    <label for="title" class="block text-sm font-semibold text-gray-700">Title <span class="text-red-600">*</span></label>
    <input id="title" name="title" type="text" value="{{ $value('title') }}" required autofocus class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
    @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="author_id" class="block text-sm font-semibold text-gray-700">Author <span class="text-red-600">*</span></label>
        <select id="author_id" name="author_id" required class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">Select an author</option>
            @foreach ($authors as $author)
                <option value="{{ $author->id }}" @selected((string) $value('author_id') === (string) $author->id)>{{ $author->name }}</option>
            @endforeach
        </select>
        @error('author_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="category_id" class="block text-sm font-semibold text-gray-700">Category <span class="text-red-600">*</span></label>
        <select id="category_id" name="category_id" required class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">Select a category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) $value('category_id') === (string) $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
<div>
    <label for="price" class="block text-sm font-semibold text-gray-700">Borrowing price <span class="text-red-600">*</span></label>
    <div class="relative mt-2">
        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500">$</span>
        <input id="price" name="price" type="number" value="{{ $value('price') }}" min="0" step="0.01" required inputmode="decimal" placeholder="0.00" class="block w-full rounded-lg border-gray-300 py-2 pl-7 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>
    <p class="mt-1 text-xs text-gray-500">This amount is charged when a member borrows the book.</p>
    @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
<div>
    <label for="cover_image" class="block text-sm font-semibold text-gray-700">Cover image</label>
    <input id="cover_image" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp,image/gif" class="mt-2 block w-full rounded-lg border border-gray-300 text-sm text-gray-700 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100">
    @if ($book?->cover_image)
        <p class="mt-1 text-xs text-gray-500">Leave blank to keep the current cover.</p>
    @endif
    @error('cover_image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
<div>
    <label for="book_file" class="block text-sm font-semibold text-gray-700">Book file <span class="text-red-600">{{ $book ? '' : '*' }}</span></label>
    <input id="book_file" name="book_file" type="file" accept="application/pdf,.epub" @required(! $book) class="mt-2 block w-full rounded-lg border border-gray-300 text-sm text-gray-700 file:mr-4 file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100">
    <p class="mt-1 text-xs text-gray-500">PDF or EPUB, up to 10 MB{{ $book ? '. Leave blank to keep the current file.' : '.' }}</p>
    @error('book_file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
<div>
    <label for="description" class="block text-sm font-semibold text-gray-700">Description</label>
    <textarea id="description" name="description" rows="5" class="mt-2 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $value('description') }}</textarea>
    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
