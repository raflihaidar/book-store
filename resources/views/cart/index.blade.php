<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($message = Session::get('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ $message }}
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ $message }}
                </div>
            @endif

            @forelse($cartItems as $item)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 flex justify-between items-center">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->book->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $item->book->author }}</p>
                            <p class="text-xl font-bold text-blue-600 mt-2">Rp {{ number_format($item->book->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 px-2 py-1 border border-gray-300 rounded">
                                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded">
                                        {{ __('Perbarui') }}
                                    </button>
                                </form>
                            </div>
                            <p class="font-bold text-lg">Rp {{ number_format($item->book->price * $item->quantity, 0, ',', '.') }}</p>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    {{ __('Hapus') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        {{ __('Keranjang Anda kosong') }}
                    </div>
                </div>
            @endforelse

            @if (count($cartItems) > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <div class="text-right mb-6">
                            <p class="text-2xl font-bold text-gray-900">
                                {{ __('Total') }}: <span class="text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <div class="flex gap-4 justify-end">
                            <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Lanjutkan Belanja') }}
                            </a>
                            <a href="{{ route('checkout') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Lanjut ke Checkout') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
