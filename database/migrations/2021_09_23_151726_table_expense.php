<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableExpense extends Migration
{
    public function up()
	{
		Schema::create('expense', function (Blueprint $table){
			$table->id();
			$table->string('id_expense')->index();
			$table->bigInteger('jumlah');
			$table->date('tgl_expense');
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
		Schema::dropIfExists('expense');
	}
}
