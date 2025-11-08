<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dasbor') }}
        </h2>
    </x-slot>

    <!-- Flash Messages -->
    @if ($message = Session::get('success'))
        <div id="successAlert" class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded shadow-lg max-w-sm">
            {{ $message }}
            <button onclick="document.getElementById('successAlert').style.display='none';" class="ml-4 font-bold">
                <span>&times;</span>
            </button>
        </div>
        <script>
            setTimeout(function() {
                const alert = document.getElementById('successAlert');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease-in-out';
                    setTimeout(() => alert.style.display = 'none', 500);
                }
            }, 2000);
        </script>
    @endif

    @if ($message = Session::get('error'))
        <div id="errorAlert" class="fixed top-4 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded shadow-lg max-w-sm">
            {{ $message }}
            <button onclick="document.getElementById('errorAlert').style.display='none';" class="ml-4 font-bold">
                <span>&times;</span>
            </button>
        </div>
        <script>
            setTimeout(function() {
                const alert = document.getElementById('errorAlert');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transition = 'opacity 0.5s ease-in-out';
                    setTimeout(() => alert.style.display = 'none', 500);
                }
            }, 2000);
        </script>
    @endif

    <div class="py-12" x-data="{ openModal: false, selectedBookId: null, quantity: 1 }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($books as $book)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                        <div class="h-48 bg-gray-200 overflow-hidden">
                            @if($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <span>{{ __('Tidak ada Gambar') }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $book->author }}</p>
                            <p class="text-xl font-bold text-blue-600 mb-4">Rp {{ number_format($book->price, 0, ',', '.') }}</p>
                            <div class="mb-4">
                                <p class="text-sm font-semibold text-gray-700">
                                    {{ __('Stok') }}:
                                    <span class="{{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $book->stock }}
                                    </span>
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('books.show', $book->id) }}" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                    {{ __('Lihat') }}
                                </a>
                                @if($isAdmin)
                                    <a href="{{ route('books.edit', $book->id) }}" class="flex-1 bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-center">
                                        {{ __('Edit') }}
                                    </a>
                                @else
                                    <button
                                        @click="openModal = true; selectedBookId = {{ $book->id }}; quantity = 1"
                                        {{ $book->stock == 0 ? 'disabled' : '' }}
                                        class="flex-1 {{ $book->stock == 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-green-500 hover:bg-green-700' }} text-white font-bold py-2 px-4 rounded">
                                        {{ $book->stock == 0 ? __('Stok Habis') : __('Beli') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500">
                        {{ __('Tidak ada buku yang tersedia') }}
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $books->links() }}
            </div>
        </div>

        <!-- Modal Quantity -->
        <div x-show="openModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openModal" @click="openModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div x-show="openModal" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="text-center mb-6">
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Pilih Jumlah') }}</h3>
                        </div>
                        <div class="flex items-center justify-center gap-4">
                            <button @click="quantity > 1 && quantity--" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">-</button>
                            <input type="number" x-model.number="quantity" min="1" class="w-20 px-4 py-2 border border-gray-300 rounded text-center">
                            <button @click="quantity++" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">+</button>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <form :action="'{{ route('cart.store') }}'" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="book_id" :value="selectedBookId">
                            <input type="hidden" name="quantity" :value="quantity">
                            <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Tambah ke Keranjang') }}
                            </button>
                        </form>
                        <button @click="openModal = false" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Batal') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
