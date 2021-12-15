<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableHarga extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga', function (Blueprint $table) {
            $table->id();
            $table->string('id_harga')->index();
            $table->float('harga_jual', 12, 3);
            $table->float('harga_beli', 12, 3);
            $table->float('harga_eceran', 12, 3)->unsigned();
            $table->date('tgl_harga');
            $table->double('diskon');
            $table->integer('margin');
            $table->string('kode_barang');
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
        Schema::dropIfExists('harga');
    }
}
