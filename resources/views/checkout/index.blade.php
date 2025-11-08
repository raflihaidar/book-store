<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Summary -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Ringkasan Pesanan') }}</h3>
                            <div class="space-y-4">
                                @foreach($cartItems as $item)
                                    <div class="flex justify-between items-center border-b pb-4">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $item->book->title }}</p>
                                            <p class="text-sm text-gray-600">{{ __('Jumlah') }}: {{ $item->quantity }}</p>
                                        </div>
                                        <p class="font-bold text-gray-900">Rp {{ number_format($item->book->price * $item->quantity, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Total -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Total Pesanan') }}</h3>
                        <div class="space-y-3 border-b pb-4 mb-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Subtotal') }}:</span>
                                <span class="font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ __('Pengiriman') }}:</span>
                                <span class="font-semibold">{{ __('Gratis') }}</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-bold">{{ __('Total') }}:</span>
                            <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <button onclick="openPaymentModal()" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-2">
                            {{ __('Selesaikan Pembelian') }}
                        </button>
                        <a href="{{ route('cart.index') }}" class="w-full block text-center bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Kembali ke Keranjang') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Masukkan Jumlah Pembayaran') }}</h3>
            <form id="paymentForm" method="POST" action="{{ route('order.store') }}" onsubmit="validatePayment(event)">
                @csrf
                <div id="errorMessage" class="mb-4 hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded"></div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Jumlah Pembayaran') }}:</label>
                    <input type="number" name="amount_paid" id="amountPaid" step="0.01" placeholder="Rp {{ number_format($total, 0, ',', '.') }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" required>
                </div>
                <div class="mb-4">
                    <p class="text-gray-600 text-sm">{{ __('Total Jumlah Hutang') }}: <span class="font-bold">Rp {{ number_format($total, 0, ',', '.') }}</span></p>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded">{{ __('Batal') }}</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-700 text-white rounded">{{ __('Proses Pembayaran') }}</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const totalAmount = {{ $total }};

        function validatePayment(event) {
            const amountPaid = parseFloat(document.getElementById('amountPaid').value);
            const errorMessage = document.getElementById('errorMessage');

            if (amountPaid < totalAmount) {
                event.preventDefault();
                errorMessage.textContent = "{{ __('Jumlah pembayaran tidak boleh kurang dari total harga') }}";
                errorMessage.classList.remove('hidden');
                return false;
            }


            errorMessage.classList.add('hidden');
            return true;
        }

        function openPaymentModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
            document.getElementById('errorMessage').classList.add('hidden');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        window.onclick = function(event) {
            const modal = document.getElementById('paymentModal');
            if (event.target === modal) {
                closePaymentModal();
            }
        }
    </script>
</x-app-layout>
