<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan #') }}{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Order Info -->
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">{{ __('Pelanggan') }}</h3>
                            <p class="text-lg text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $order->user->email }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">{{ __('Status') }}</h3>
                            <span class="inline-block bg-green-100 text-green-800 text-sm font-semibold px-3 py-1 rounded mt-2">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">{{ __('Tanggal Pesanan') }}</h3>
                            <p class="text-lg text-gray-900">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">{{ __('Tanggal Update') }}</h3>
                            <p class="text-lg text-gray-900">{{ $order->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Item Pesanan') }}</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs font-semibold text-gray-700 bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3">{{ __('Buku') }}</th>
                                        <th class="px-6 py-3">{{ __('Harga') }}</th>
                                        <th class="px-6 py-3">{{ __('Jumlah') }}</th>
                                        <th class="px-6 py-3">{{ __('Total') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($order->items as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->book->title }}</td>
                                            <td class="px-6 py-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4">{{ $item->quantity }}</td>
                                            <td class="px-6 py-4 text-blue-600 font-semibold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="bg-gray-50 p-6 rounded-lg mb-8">
                        <div class="flex justify-between mb-3">
                            <span class="text-gray-600">{{ __('Total Jumlah') }}</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-3 pb-3 border-b border-gray-200">
                            <span class="text-gray-600">{{ __('Jumlah Dibayar') }}</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($order->amount_paid, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">{{ __('Kembalian') }}</span>
                            <span class="font-semibold {{ $order->amount_paid - $order->total_amount >= 0 ? 'text-green-600' : 'text-red-600' }}">Rp {{ number_format($order->amount_paid - $order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <a href="{{ auth()->user()->role->name === 'admin' ? route('admin.orders.index') : route('orders.index') }}" class="inline-block bg-gray-500 text-white text-sm font-semibold px-4 py-2 rounded hover:bg-gray-600">
                        {{ __('Kembali') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
