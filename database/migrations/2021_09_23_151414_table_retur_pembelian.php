<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableReturPembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('id_retur_beli')->index();
            $table->date('tgl_retur');
            $table->string('id_list_order');
            $table->text('deskripsi');
            $table->integer('jml_retur');
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('retur_pembelian');
    }
}
