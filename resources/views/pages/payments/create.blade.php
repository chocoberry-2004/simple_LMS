<x-public-layout>

    <form action="{{ route('payments.store', $borrowing) }}" enctype="multipart/form-data" method="POST" class="mx-auto mt-10 max-w-2xl space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        <div class="flex flex-col sm:flex-row justify-between items-start gap-6">
            <div class="w-full sm:flex-1 space-y-4">
                 <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1.5">Amount</label>
                    <input type="text" id="amount" value="${{ number_format($borrowing->book->price, 2) }}" readonly class="block w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2.5 text-sm text-gray-900 shadow-sm">
                    <p class="mt-1 text-xs text-gray-500">{{ $borrowing->book->title }}</p>
                </div>

                <div>
                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1.5">Payment Method</label>
                    <input type="text" id='payment_method' value="{{ old('payment_method') }}" name="payment_method"  class=" block w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2.5 text-sm text-gray-900 shadow-sm">
                    @error('payment_method') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="transaction_id" class="block text-sm font-medium text-gray-700 mb-1.5">Transaction ID</label>
                    <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}" required placeholder="Enter transaction ID" class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200">
                    @error('transaction_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="receipt_url" class="block text-sm font-medium text-gray-700 mb-1.5">Payment Receipt</label>
                    <input type="file" name="receipt" id="receipt" accept="image/*" class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-500 shadow-sm transition file:mr-3 file:cursor-pointer file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    @error('receipt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

            </div>

            <div class="flex w-full flex-col items-center sm:w-auto sm:items-end sm:pt-1">
                <label class="mb-2 block text-sm font-medium text-gray-700">Payment QR</label>
                <div class="rounded-xl border border-gray-200 bg-white p-3 shadow-sm">
                    <img src="{{ asset('images/payment-qr.jpg') }}" alt="Payment QR Code" class="h-56 w-56 rounded-lg object-contain sm:h-64 sm:w-64">
                </div>
                <p class="mt-2 text-xs text-gray-400">Scan with your banking app</p>
            </div>
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">Notes</label>
            <textarea name="notes" id="notes" cols="30" rows="5" placeholder="Add any additional notes here..." class="block w-full rounded-lg border border-gray-300 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 placeholder-gray-400 shadow-sm transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200 resize-y">{{ old('notes') }}</textarea>
            @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">Submit Payment</button>
    </form>

</x-public-layout>
