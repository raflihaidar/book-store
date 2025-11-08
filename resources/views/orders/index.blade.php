<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($orders->isEmpty())
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded">
                    {{ __('Anda belum membuat pesanan.') }}
                    <a href="{{ route('dashboard') }}" class="font-semibold underline">{{ __('Mulai berbelanja') }}</a>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs font-semibold text-gray-700 bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3">{{ __('ID Pesanan') }}</th>
                                        <th class="px-6 py-3">{{ __('Tanggal') }}</th>
                                        <th class="px-6 py-3">{{ __('Total Jumlah') }}</th>
                                        <th class="px-6 py-3">{{ __('Jumlah Dibayar') }}</th>
                                        <th class="px-6 py-3">{{ __('Status') }}</th>
                                        <th class="px-6 py-3">{{ __('Aksi') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($orders as $order)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->id }}</td>
                                            <td class="px-6 py-4">{{ $order->order_date->format('d M Y, H:i') }}</td>
                                            <td class="px-6 py-4 text-blue-600 font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4">Rp {{ number_format($order->amount_paid, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-left">
                                                <a href="{{ route('orders.show', $order->id) }}" class="inline-block bg-blue-500 text-white text-xs font-semibold px-3 py-1 rounded hover:bg-blue-600">
                                                    {{ __('Lihat') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
