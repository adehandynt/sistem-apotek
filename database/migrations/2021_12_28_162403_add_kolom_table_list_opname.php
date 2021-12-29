<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKolomTableListOpname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('list_opname','masuk')){
            Schema::table('list_opname', function (Blueprint $table) {
                $table->integer('masuk');
            });
        }

        if(!Schema::hasColumn('list_opname','keluar')){
            Schema::table('list_opname', function (Blueprint $table) {
                $table->integer('keluar');
            });
        }

        if(!Schema::hasColumn('list_opname','saldo_akhir')){
            Schema::table('list_opname', function (Blueprint $table) {
                $table->integer('saldo_akhir');
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
        Schema::table('list_opname', function (Blueprint $table) {
            $table->dropColumn(['masuk','keluar','saldo_akhir']);
        });
    }
}
