<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Buku') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Search & Add Button -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <!-- Search Form -->
                <form method="GET" action="{{ route('books.index') }}" class="md:col-span-2">
                    <div class="flex gap-2">
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari buku berdasarkan judul, penulis..."
                            value="{{ $search ?? '' }}"
                            class="flex-grow px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                        >
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-semibold whitespace-nowrap"
                        >
                            {{ __('Cari') }}
                        </button>
                    </div>
                </form>

                <!-- Add Button -->
                <div class="flex justify-center md:justify-end">
                    <a
                        href="{{ route('books.create') }}"
                        class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded hover:bg-green-200"
                    >
                        + {{ __('Tambah Buku Baru') }}
                    </a>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 sm:px-6 py-4 font-semibold text-gray-800">#</th>
                                <th class="px-4 sm:px-6 py-4 font-semibold text-gray-800">{{ __('Gambar') }}</th>
                                <th class="px-4 sm:px-6 py-4 font-semibold text-gray-800">{{ __('Judul') }}</th>
                                <th class="px-4 sm:px-6 py-4 font-semibold text-gray-800 hidden sm:table-cell">{{ __('Penulis') }}</th>
                                <th class="px-4 sm:px-6 py-4 font-semibold text-gray-800">{{ __('Harga') }}</th>
                                <th class="px-4 sm:px-6 py-4 font-semibold text-gray-800">{{ __('Stok') }}</th>
                                <th class="px-4 sm:px-6 py-4 font-semibold text-gray-800 text-center">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($books as $index => $book)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-4 sm:px-6 py-4 text-gray-900 font-medium">
                                        {{ ($books->currentPage() - 1) * $books->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4">
                                        <img
                                            src="{{ Storage::url($book->image) }}"
                                            alt="{{ $book->title }}"
                                            class="w-10 h-10 object-cover rounded-lg shadow-sm"
                                        >
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 font-semibold text-gray-900">
                                        {{ Str::limit($book->title, 30) }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 hidden sm:table-cell text-gray-700">
                                        {{ Str::limit($book->author, 20) }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4 font-bold text-green-600">
                                        Rp {{ number_format($book->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $book->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $book->stock > 0 ? $book->stock : 'Habis' }}
                                        </span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <a
                                                href="{{ route('books.show', $book) }}"
                                                class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded hover:bg-blue-200"
                                            >
                                                {{ __('Lihat') }}
                                            </a>
                                            <a
                                                href="{{ route('books.edit', $book) }}"
                                                class="inline-block bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded hover:bg-yellow-200"
                                            >
                                                {{ __('Edit') }}
                                            </a>
                                            <form
                                                action="{{ route('books.destroy', $book) }}"
                                                method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded hover:bg-red-200"
                                                >
                                                    {{ __('Hapus') }}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        <i class="fas fa-inbox text-4xl mb-3 opacity-50"></i>
                                        <p class="font-medium">{{ __('Tidak ada buku yang ditemukan') }}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-6 border-t border-gray-200 bg-gray-50">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="text-sm text-gray-600">
                            <span class="font-semibold text-gray-800">{{ __('Total Buku') }}:</span> {{ $books->total() }} |
                            <span class="font-semibold text-gray-800">{{ __('Per Halaman') }}:</span> {{ $books->perPage() }} |
                            <span class="font-semibold text-gray-800">{{ __('Halaman Saat Ini') }}:</span> {{ $books->currentPage() }} / {{ $books->lastPage() }}
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <div class="text-sm text-gray-600">
                                <span class="font-semibold text-gray-800">{{ __('Menampilkan') }}:</span>
                                {{ ($books->currentPage() - 1) * $books->perPage() + 1 }} - {{ min($books->currentPage() * $books->perPage(), $books->total()) }}
                            </div>
                            {{ $books->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
