<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
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

            <!-- Welcome toast -->


            <div class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive"
                 aria-atomic="true" id="myToast">
                <div class="d-flex">
                    <div class="toast-body">
                        Hello, {{ Auth::user()->name }}! Welcome to payment service app!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" style="color: black;"
                            data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <br><br>
        </div>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <!-- Transfers Card -->
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Easy and Secure Transfers</h5>
                            <p class="card-text">Make fast and secure transfers with our app. Transfer funds between
                                your accounts or to external accounts with ease. Enjoy low fees and real-time
                                transaction processing.</p>
                            <a href="{{ route('transfers') }}" class="btn btn-primary">Start</a>
                        </div>
                    </div>
                </div>

                <!-- Investments Card -->
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cryptocurrency Investments</h5>
                            <p class="card-text">Dive into the world of cryptocurrency with our app. Invest in popular
                                cryptocurrencies like Bitcoin, Ethereum, and Litecoin. Track your investments and grow
                                your portfolio.</p>
                            <a href="{{ route('investments') }}" class="btn btn-primary">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myToastEl = document.getElementById('myToast');
        if (myToastEl) {
            var myToast = new bootstrap.Toast(myToastEl, {
                delay: 6000  // Delay in milliseconds
            });

            myToast.show(); // This shows the toast
        }
    });
</script>
