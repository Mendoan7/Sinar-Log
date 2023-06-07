<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warranty_history', function (Blueprint $table) {
            $table->foreignId('transaction_id', 'fk_warranty_history_to_transaction')->references('id')->on('transaction')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('warranty_history', function (Blueprint $table) {
            $table->dropForeign('fk_warranty_history_to_transaction');
        });
    }
};
