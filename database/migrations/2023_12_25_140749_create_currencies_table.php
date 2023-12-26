<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{

    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->string('symbol')->primary();
            $table->decimal('rate', 10, 4);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
}
