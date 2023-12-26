<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptosTable extends Migration
{
    public function up(): void
    {
        Schema::create('cryptos', function (Blueprint $table) {
            $table->string('crypto_symbol')->primary();
            $table->decimal('EUR', 10, 4);
            $table->decimal('USD', 10, 4);
            $table->decimal('GBP', 10, 4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cryptos');
    }
}
