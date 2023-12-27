<x-app-layout>
    <x-slot name="header">
        @if ($investmentAccount)
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Your investments accounts ') }} {{ $investmentAccount->account_no }} {{ __('balance is EUR ') }} {{ number_format($investmentAccount->balance / 100, 2) }}
            </h2>
        @else
            <form action="{{ route('investments.create') }}" method="POST">
                @csrf
                <button type="submit" style="background-color: #4CAF50; /* Green */
                            border: none;
                            color: white;
                            padding: 15px 32px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 16px;
                            margin: 4px 2px;
                            cursor: pointer;">
                    {{ __('Create Investment Account') }}
                </button>
            </form>
        @endif
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Check for Success Message -->
            @if (session('success'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Investments
                    </h2>

                    <table class="min-w-full divide-y divide-gray-200 mb-4">
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
                        @foreach ($activeInvestments as $activeInvestment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $activeInvestment->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $activeInvestment->crypto_symbol }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($activeInvestment->purchaseValue, 2) }} EUR
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($activeInvestment->currentValue, 2) }} EUR
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="{{ $activeInvestment->percentageChange > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($activeInvestment->percentageChange, 2) }}%
                                    </span>
                                </td>

                                <!-- Sell Button -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('investments.sell', ['investment_ID' => $activeInvestment->id]) }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900">Sell</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table><br>
                    <div class="mt-4 text-right mb-4">
                        <a href="{{ route('investments.create') }}" class="create-investment-btn">
                            New Investment
                        </a>
                    </div>

                </div>

            </div><br>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Investment history
                    </h2>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Investment status
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
                                Sale Value
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Value change %
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($soldInvestments as $soldInvestment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-red-600">
                                    {{ $soldInvestment->status }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $soldInvestment->crypto_symbol }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($soldInvestment->purchaseValue, 2) }} EUR
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($soldInvestment->saleValue, 2) }} EUR
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="{{ $soldInvestment->percentageChange > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($soldInvestment->percentageChange, 2) }}%
                                    </span>
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
