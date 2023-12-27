<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Investments') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Today's investment options
                    </h2>

                    <table class="min-w-full divide-y divide-gray-200">
                        <tbody class="bg-white divide-y divide-gray-200">

                        @foreach ($cryptoRates as $crypto)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="/images/{{ strtolower($crypto->crypto_symbol) }}.png" alt="{{ $crypto->crypto_symbol }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $crypto->crypto_symbol }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($crypto->EUR, 4) }} EUR
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div><br>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Make your next investment
                    </h2>

                    <form action="{{ route('investments.store') }}" method="POST">
                        @csrf
                        <table class="custom-table">

                            <tbody>
                            <tr>
                                <td>
                                    <select name="crypto_symbol" id="crypto_symbol" class="select-dropdown">
                                        @foreach ($cryptoRates as $crypto)
                                            <option value="{{ $crypto->crypto_symbol }}">{{ $crypto->crypto_symbol }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <div class="flex items-center">
                                        <button type="button" id="decrement" class="increment-decrement-btn">-</button>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" class="quantity-input" />
                                        <button type="button" id="increment" class="increment-decrement-btn">+</button>
                                    </div>
                                </td>
                                <td>
                                    <span id="total">0.00</span> EUR
                                </td>
                                <td>
                                    <button type="submit" class="btn">Invest</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const totalSpan = document.getElementById('total');
        const cryptoRates = @json($cryptoRates->pluck('EUR', 'crypto_symbol'));

        function updateTotal() {
            const cryptoSymbol = document.getElementById('crypto_symbol').value;
            const quantity = parseInt(quantityInput.value);
            const rate = cryptoRates[cryptoSymbol];
            totalSpan.textContent = (quantity * rate).toFixed(2);
        }

        document.getElementById('increment').addEventListener('click', () => {
            quantityInput.value = parseInt(quantityInput.value) + 1;
            updateTotal();
        });

        document.getElementById('decrement').addEventListener('click', () => {
            if (quantityInput.value > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                updateTotal();
            }
        });

        quantityInput.addEventListener('input', updateTotal);
        document.getElementById('crypto_symbol').addEventListener('change', updateTotal);

        // Initial total calculation
        updateTotal();
    });
</script>
