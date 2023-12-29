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

            <!-- Display Error Message -->
            @if ($errors->any())
                <div class="mb-4">
                    <div class="font-medium text-red-600">
                        {{ __('Whoops! Something went wrong.') }}
                    </div>

                    <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                        Accounts
                    </h2>

                    @if(!$accounts->isEmpty())
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Account No
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Balance
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                    <!-- Delete Button -->
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form
                                            action="{{ route('my-accounts.delete', ['account_no' => $account->account_no]) }}"
                                            method="POST" onsubmit="return confirmDelete()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600">Delete Account</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table><br>
                    @else
                        <p class="text-gray-600">Press New Account to create your first account.</p><br>
                    @endif
                    <div class="mt-4 text-right mb-4">
                        <a href="{{ route('my-accounts.create') }}" class="create-investment-btn">
                            New Account
                        </a>
                    </div>
                </div>
            </div>
                <br>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <h2 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            Investment Account
                        </h2>

                        @if(!$investmentAccounts->isEmpty())
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Account No
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Balance
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Currency
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($investmentAccounts as $account)
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
                                        <!-- Delete Button -->
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form
                                                action="{{ route('my-accounts.delete', ['account_no' => $account->account_no]) }}"
                                                method="POST" onsubmit="return confirmDelete()">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600">Delete Account</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table><br>
                        @else
                            <p class="text-gray-600">You don't have a Investment Account</p><br>
                            <form action="{{ route('investments.create-account') }}" method="POST">
                                @csrf
                                <button type="submit" class="create-investment-btn">
                                    {{ __('Create Investment Account') }}
                                </button>
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this account?');
    }
</script>
