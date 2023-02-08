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
            $table->id();
            $table->string('kode_servis');
            $table->string('jenis');
            $table->string('tipe');
            $table->string('kelengkapan');
            $table->string('kerusakan');
            $table->string('penerima');
            $table->enum('status', [1,2,3,4,5,6,7,8]);
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
