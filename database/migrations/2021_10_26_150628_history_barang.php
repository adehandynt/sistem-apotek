<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class HistoryBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_barang', function (Blueprint $table){
			$table->id();
			$table->string('id_history')->index();
			$table->text('kode_barang');
			$table->dateTime('tgl_masuk')->nullable();
            $table->dateTime('tgl_keluar')->nullable();
            $table->string('jml_masuk')->nullable();
            $table->string('jml_keluar')->nullable();
            $table->string('jenis_history');
            $table->integer('sisa');
            $table->string('pic');
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_barang');
    }
}
