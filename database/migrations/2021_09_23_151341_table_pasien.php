<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablePasien extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->index()->unique();
            $table->string('nama_pasien');
            $table->date('tgl_lahir');
            $table->string('jenis_kelamin');
            $table->integer('umur_pasien');
            $table->text('alamat_pasien');
            $table->bigInteger('no_telp_pasien');
            $table->string('golongan_darah');
            $table->string('no_bpjs')->nullable();
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
        Schema::dropIfExists('pasien');
    }
}
