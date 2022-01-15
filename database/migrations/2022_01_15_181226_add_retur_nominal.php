<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturNominal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('retur_penjualan','retur_nominal')){
            Schema::table('retur_penjualan', function (Blueprint $table) {
                $table->double('retur_nominal')->default('0');
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
        Schema::table('retur_penjualan', function (Blueprint $table) {
            $table->dropColumn(['retur_nominal']);
        });
    }
}
