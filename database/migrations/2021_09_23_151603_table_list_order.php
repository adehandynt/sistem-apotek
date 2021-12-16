<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableListOrder extends Migration
{
    /**
	* Run the migrations.
	*
	*@return void
	*/

	public function up()
	{
		Schema::create('list_order', function (Blueprint $table){
			$table->id();
			$table->string('id_list_order')->index();
			$table->string('kode_barang');
			$table->string('id_order');
			$table->integer('jumlah');
			$table->bigInteger('harga_beli');
			$table->double('diskon');
			$table->bigInteger('total');
			$table->string('kode_satuan');
			$table->double('ppn')->default(0);
			$table->integer('jumlah_diterima')->nullable();
			$table->string('status_terima')->nullable();
			$table->string('deskripsi')->nullable();
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
		Schema::dropIfExists('list_order');
	}
}
