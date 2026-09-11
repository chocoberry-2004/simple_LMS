<x-admin-layout>
    <div class="mx-auto max-w-5xl">
        <h1 class="text-2xl font-bold text-gray-900">Payments</h1>

        @if (session('success'))
            <div class="mt-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-800" role="status">{{ session('success') }}</div>
        @endif

        <div class="mt-5 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <table class="w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">Member</th>
                        <th class="px-4 py-2 text-left">Book</th>
                        <th class="px-4 py-2 text-left">Amount</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Paid At</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $payment->member->user->name }}</td>
                            <td class="px-4 py-2">{{ $payment->book->title }}</td>
                            <td class="px-4 py-2">${{ number_format($payment->amount, 2) }}</td>
                            <td class="px-4 py-2 capitalize">{{ $payment->status }}</td>
                            <td class="px-4 py-2">{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : 'N/A' }}</td>
                            <td class="px-4 py-2">
                                @if ($payment->status === 'pending')
                                    <form action="{{ route('payments.complete', $payment) }}" method="POST" onsubmit="return confirm('Mark this payment as completed?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="rounded-lg bg-green-600 px-3 py-1 text-sm font-semibold text-white hover:bg-green-700">Mark as Completed</button>
                                    </form>         
                        @else
                            <span class="text-gray-500">No actions available</span> 
                                    
                                @endif
                            </td>   

                        </tr>
                    @endforeach 

                </tbody>
            </table>

            <div class="mt-4 px-4 py-2">
                {{ $payments->links() }}    

            </div>
        </div>  
    </div>
</x-admin-layout>

