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
        Schema::table('service_detail', function (Blueprint $table) {
            $table->foreignUuid('service_id', 'fk_service_detail_to_service')->references('id')->on('service')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_detail', function (Blueprint $table) {
            $table->dropForeign('fk_service_detail_to_service');
        });
    }
};
