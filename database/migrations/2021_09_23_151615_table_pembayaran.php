<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablePembayaran extends Migration
{
    public function up()
	{
		Schema::create('pembayaran', function (Blueprint $table){
			$table->id();
			$table->string('id_referensi')->index()->nullable();
			$table->string('id_pembayaran');
			$table->string('jenis_bayar');
			$table->text('deskripsi');
			$table->string('metode_pembayaran');
			$table->bigInteger('tagihan');
			$table->bigInteger('terbayar');
			$table->dateTime('tgl_bayar');
			$table->string('status');
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
		Schema::dropIfExists('pembayaran');
	}
}
