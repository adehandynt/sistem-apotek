<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusBayar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('transaksi','status_transaksi')){
            Schema::table('transaksi', function (Blueprint $table) {
                $table->string('status_transaksi')->nullable();
            });
        }

        if(!Schema::hasColumn('transaksi','no_bpjs')){
            Schema::table('transaksi', function (Blueprint $table) {
                $table->string('no_bpjs')->nullable();
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
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn(['status_transaksi','no_bpjs']);
        });
    }
}
