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
        Schema::create('service', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_servis');
            $table->string('jenis');
            $table->string('tipe');
            $table->string('kelengkapan');
            $table->string('penerima');
            $table->unsignedBigInteger('teknisi')->nullable();
            $table->foreign('teknisi')->references('id')->on('users');
            $table->enum('status', [1,2,3,4,5,6,7,8,9,10,11]);
            $table->string('estimasi_tindakan')->nullable();
            $table->string('estimasi_biaya')->nullable();
            $table->string('confirmation_token')->nullable();
            $table->timestamp('expired_time')->nullable();
            $table->string('pengambil')->nullable();
            $table->string('penyerah')->nullable();
            $table->timestamp('date_done')->nullable();
            $table->timestamp('date_out')->nullable();
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
        Schema::dropIfExists('service');
    }
};
