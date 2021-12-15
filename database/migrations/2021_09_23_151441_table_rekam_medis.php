<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableRekamMedis extends Migration
{
  /**
	* Run the migrations.
	*
	*@return void
	*/

	public function up()
	{
		Schema::create('rekam_medis', function (Blueprint $table){
			$table->id();
			$table->string('id_rekam_medis')->index();
			$table->string('tekanan_darah');
			$table->string('saturasi_oksigen');
			$table->date('tgl_rekam');
			$table->string('nik');
			$table->string('nip');
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
		Schema::dropIfExists('rekam_medis');
	}
}
