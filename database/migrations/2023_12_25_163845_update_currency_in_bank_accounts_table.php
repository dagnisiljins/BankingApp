<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateCurrencyInBankAccountsTable extends Migration
{

    public function up(): void
    {
        // First, change the column to a temporary string column
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->string('temp_currency')->default('EUR');
        });

        // Update the temporary column with the existing currency values
        DB::table('bank_accounts')->update(['temp_currency' => DB::raw('currency')]);

        // Drop the old enum column
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('currency');
        });

        // Add the new enum column with correct values
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->enum('currency', ['EUR', 'GBP', 'USD']);
        });

        // Update the new column with values from the temporary column
        DB::table('bank_accounts')->update(['currency' => DB::raw('temp_currency')]);

        // Drop the temporary column
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('temp_currency');
        });
    }


    public function down(): void
    {
        //
    }
}
