<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableJasaDokter extends Migration
{
    /**
	* Run the migrations.
	*
	*@return void
	*/

	public function up()
	{
		Schema::create('jasa_dokter', function (Blueprint $table){
			$table->id();
			$table->string('id_jasa_dokter')->index();
			$table->string('no_transaksi');
			$table->bigInteger('biaya');
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
		Schema::dropIfExists('jasa_dokter');
	}
}
