<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableDokumen extends Migration
{
    public function up()
	{
		Schema::create('dokumen', function (Blueprint $table){
			$table->id();
			$table->string('no_dokumen')->index();
			$table->string('nip');
			$table->text('dokumen');
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
		Schema::dropIfExists('dokumen');
	}
}
