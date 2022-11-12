<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAkomodasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('akomodasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('foto');
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('kabupaten_id');
            $table->unsignedBigInteger('category_akomodasi_id');
            $table->string('nama_akomodasi');
            $table->string('lokasi');
            $table->string('status');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('member');
            $table->foreign('kabupaten_id')->references('id_kabupaten')->on('kabupatens');
            $table->foreign('category_akomodasi_id')->references('id')->on('akomodasis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akomodasis');
    }
}
