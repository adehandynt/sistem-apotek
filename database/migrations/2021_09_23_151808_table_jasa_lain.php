<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableJasaLain extends Migration
{
    public function up()
	{
		Schema::create('jasa_lain', function (Blueprint $table){
			$table->id();
			$table->string('id_jasa')->index();
			$table->string('no_transaksi');
			$table->string('biaya');
			$table->integer('jml_jasa');
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
		Schema::dropIfExists('jasa_lain');
	}
}
