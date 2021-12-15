<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->index();
            $table->string('nama_barang');
            $table->string('produsen');
            $table->string('kode_tipe');
            $table->string('kode_satuan');
            $table->integer('jml_per_satuan');
            $table->integer('status_ecer')->unsigned();
            $table->string('penyimpanan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
