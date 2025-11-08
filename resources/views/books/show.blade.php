<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-8">
                    <!-- Image Section -->
                    @if ($book->image)
                        <div class="md:col-span-1 flex flex-col items-center justify-start">
                            <img
                                src="{{ asset('storage/' . $book->image) }}"
                                alt="{{ $book->title }}"
                                class="rounded-lg shadow-md w-full h-auto object-cover"
                            >
                        </div>
                    @endif

                    <!-- Details Section -->
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                            <p class="text-lg text-blue-600 font-semibold">by {{ $book->author }}</p>
                        </div>

                        <div class="border-t pt-6 space-y-4">
                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                <span class="text-gray-700 font-semibold">Price:</span>
                                <span class="text-2xl font-bold text-green-600">Rp {{ number_format($book->price, 2) }}</span>
                            </div>

                            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                                <span class="text-gray-700 font-semibold">Stock Available:</span>
                                <span class="text-lg font-bold {{ $book->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $book->stock > 0 ? $book->stock . ' units' : 'Out of Stock' }}
                                </span>
                            </div>
                        </div>

                        <div class="border-t pt-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                            <p class="text-gray-600 leading-relaxed text-justify">{{ $book->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="border-t bg-gray-50 px-8 py-6 flex flex-col sm:flex-row gap-4">
                    <a
                        href="{{ auth()->user()->role->name === 'admin' ? route('books.index') : route('dashboard') }}"
                        class="inline-flex items-center justify-center bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 font-medium"
                    >
                        ← {{ auth()->user()->role->name === 'admin' ? 'Back to List' : 'Back to Dashboard' }}
                    </a>
                    @if (auth()->user()->role->name === 'admin')
                        <a
                            href="{{ route('books.edit', $book) }}"
                            class="inline-flex items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium"
                        >
                            ✎ Edit Book
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
