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
        Schema::create('service_detail', function (Blueprint $table) {
            $table->id();
            $table->string('kerusakan');
            $table->enum('kondisi', [1,2,3])->nullable();
            $table->string('tindakan')->nullable();
            $table->string('modal')->nullable();
            $table->string('biaya')->nullable();
            $table->string('pembayaran')->nullable();
            $table->string('garansi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_detail');
    }
};
