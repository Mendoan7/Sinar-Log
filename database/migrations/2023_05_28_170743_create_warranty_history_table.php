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
        Schema::create('warranty_history', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
            $table->enum('kondisi', [1,2,3])->nullable();
            $table->string('tindakan')->nullable();
            $table->string('catatan')->nullable();
            $table->string('pengambil')->nullable();
            $table->string('penyerah')->nullable();
            $table->enum('status', [1,2,3]);
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
        Schema::dropIfExists('warranty_history');
    }
};
