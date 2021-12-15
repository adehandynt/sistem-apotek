<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableAkun extends Migration
{
   /**
	* Run the migrations.
	*
	*@return void
	*/

	public function up()
	{
		Schema::create('akun', function (Blueprint $table){
			$table->id();
			$table->string('nip');
			$table->string('username')->index();
			$table->string('password');
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
		Schema::dropIfExists('akun');
	}
}
