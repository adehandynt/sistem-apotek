<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableTindakan extends Migration
{
    public function up()
	{
		Schema::create('tindakan', function (Blueprint $table){
			$table->id();
			$table->string('id_tindakan')->index();
			$table->text('tindakan');
			$table->bigInteger('biaya');
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
		Schema::dropIfExists('tindakan');
	}
}
