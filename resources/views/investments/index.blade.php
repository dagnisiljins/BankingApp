<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Investments') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Investment ID
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Symbol
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Purchase Value
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Todays Value
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Value change %
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($investments as $investment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $investment->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $investment->crypto_symbol }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($investment->purchaseValue, 4) }} EUR
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($investment->currentValue, 4) }} EUR
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="{{ $investment->percentageChange > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($investment->percentageChange, 2) }}%
                                    </span>
                                </td>

                                <!-- Sell Button -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('investments.sell', ['from_investment' => $investment->id]) }}"
                                       class="text-indigo-600 hover:text-indigo-900">Sell</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
