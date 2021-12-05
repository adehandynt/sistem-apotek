<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableItemPenjualan extends Migration
{
    public function up()
	{
		Schema::create('item_penjualan', function (Blueprint $table){
			$table->id();
			$table->string('id_item')->index();
			$table->string('no_transaksi');
			$table->string('kode_barang');
			$table->integer('jumlah');
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
		Schema::dropIfExists('item_penjualan');
	}
}
