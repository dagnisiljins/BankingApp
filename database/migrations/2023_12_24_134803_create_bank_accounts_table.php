<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountsTable extends Migration
{

    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->string('account_no')->primary(); // Account No as Primary Key
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->enum('currency', ['EUR', 'GBH', 'USD']); // Currency field
            $table->bigInteger('balance'); // Account balance in cents
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
}
