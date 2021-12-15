<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableTransaksi extends Migration
{
    public function up()
	{
		Schema::create('transaksi', function (Blueprint $table){
			$table->id();
			$table->string('no_transaksi')->index();
			$table->dateTime('tgl_transaksi');
			$table->bigInteger('total');
			$table->string('nip');
			$table->bigInteger('uang_diterima');
			$table->bigInteger('uang_kembalian');
			$table->string('metode_pembayaran');
			$table->string('bank')->nullable();
			$table->string('no_kartu')->nullable();
			$table->string('bpjs')->nullable();
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
		Schema::dropIfExists('transaksi');
	}
}
