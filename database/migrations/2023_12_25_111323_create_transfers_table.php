<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{

    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('from_account');
            $table->string('to_account');
            $table->bigInteger('sent_amount'); // Add the new initial_amount column *************
            $table->bigInteger('received_amount'); // Store amount in cents
            $table->string('sent_currency'); //
            $table->string('received_currency');
            $table->string('payment_reference');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
}
