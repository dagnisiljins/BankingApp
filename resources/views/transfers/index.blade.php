<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transfers') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Account No
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Balance
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Currency
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($accounts as $account)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $account->account_no }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($account->balance / 100, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $account->currency }}
                                </td>
                                <!-- New Buttons -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('transfers.create', ['from_account' => $account->account_no]) }}" class="text-indigo-600 hover:text-indigo-900">New Transfer</a>
                                    <a href="{{ route('transfers.history', ['account' => $account->account_no]) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">Transfer History</a>
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
