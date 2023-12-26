<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transfer from account: ') . request()->query('from_account') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

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

                    <form method="POST" action="{{ route('transfers.store') }}">
                        @csrf

                        <!-- Senders Account Number -->
                        <div class="mb-4">
                            <label for="senders_account" class="block text-sm font-medium text-gray-700">Sender's account No</label>
                            <input type="text" id="senders_account" name="senders_account" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ request()->query('from_account') }}" readonly>
                        </div>

                        <!-- Recipient Account Number -->
                        <div class="mb-4">
                            <label for="recipient_account" class="block text-sm font-medium text-gray-700">Recipient account No</label>
                            <input type="text" id="recipient_account" name="recipient_account" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Recipient account No">
                        </div>

                        <!-- Transfer Amount -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Transfer amount</label>
                            <input type="text" id="amount" name="amount" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="0.00">
                        </div>

                        <!-- Payment Reference -->
                        <div class="mb-4">
                            <label for="reference" class="block text-sm font-medium text-gray-700">Reference</label>
                            <input type="text" id="reference" name="reference" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Reference">
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" style="background-color: blue; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
                                Make Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
