<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsAccountsTable extends Migration
{
    public function up(): void
    {
        Schema::create('investments_accounts', function (Blueprint $table) {
            $table->string('account_no')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('currency', ['EUR']);
            $table->bigInteger('balance');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investments_accounts');
    }
}
