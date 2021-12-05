<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableReturPenjualan extends Migration
{
    /**
	* Run the migrations.
	*
	*@return void
	*/

	public function up()
	{
		Schema::create('retur_penjualan', function (Blueprint $table){
			$table->id();
			$table->string('id_retur_jual')->index();
			$table->string('no_transaksi');
			$table->string('kode_barang');
			$table->integer('jumlah');
			$table->date('tgl_retur');
			$table->text('deskripsi');
			$table->timestamps();
		});
	}

	/**
	* Reverse the migrations.
	*
	*@return void
	*/

	public function down()
	{
		Schema::dropIfExists('retur_penjualan');
	}
}
