<x-app-layout>
    <x-slot name="header">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Accounts') }}
            </h2>
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Fixed Button -->
    <div style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
        <a href="{{ route('my-accounts.create') }}" style="background-color: blue; color: white; padding: 15px; border-radius: 50%; text-align: center; display: flex; justify-content: center; align-items: center; width: 50px; height: 50px; text-decoration: none; transition: background-color 0.3s;">
            <svg xmlns="http://www.w3.org/2000/svg" style="width: 24px; height: 24px;" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </a>
    </div>
</x-app-layout>
