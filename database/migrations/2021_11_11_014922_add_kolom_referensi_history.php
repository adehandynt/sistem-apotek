<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKolomReferensiHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('history_barang','id_referensi')){
            Schema::table('history_barang', function (Blueprint $table) {
                $table->string('id_referensi');
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
        Schema::table('history_barang', function (Blueprint $table) {
            $table->dropColumn(['id_referensi']);
        });
    }

}
