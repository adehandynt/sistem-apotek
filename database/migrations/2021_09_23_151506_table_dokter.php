<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableDokter extends Migration
{
   /**
	* Run the migrations.
	*
	*@return void
	*/

	public function up()
	{
		Schema::create('dokter', function (Blueprint $table){
			$table->id();
			$table->string('nip');
			$table->string('no_konsil')->index();
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
		Schema::dropIfExists('dokter');
	}
}
