<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKolomJenisBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('tipe','jenis_barang')){
            Schema::table('tipe', function (Blueprint $table) {
                $table->string('jenis_barang');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipe', function (Blueprint $table) {
            $table->dropColumn(['jenis_barang']);
        });
    }
}
