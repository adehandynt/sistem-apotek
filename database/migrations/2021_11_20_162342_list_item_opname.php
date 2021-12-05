<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ListItemOpname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_opname', function (Blueprint $table) {
            $table->id();
            $table->string('id_list_opname')->index();
            $table->string('id_opname');
            $table->string('kode_barang');
            $table->integer('jml_tercatat')->default('0');
            $table->integer('jml_fisik')->default('0');
            $table->integer('hilang')->default('0');
            $table->integer('rusak')->default('0');
            $table->integer('selisih')->default('0');
            $table->integer('balance')->default('0');
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
        Schema::dropIfExists('list_opname');
    }
}
