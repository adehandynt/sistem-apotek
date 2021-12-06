<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPembelian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('orders','status_pembelian')){
            Schema::table('orders', function (Blueprint $table) {
                $table->integer('status_pembelian')->nullable();
            });
        }

        if(!Schema::hasColumn('orders','no_faktur')){
            Schema::table('orders', function (Blueprint $table) {
                $table->string('no_faktur')->nullable();
            });
        }
        
        if(!Schema::hasColumn('orders','supplier_do')){
            Schema::table('orders', function (Blueprint $table) {
                $table->string('supplier_do')->nullable();
            });
        }

        if(!Schema::hasColumn('orders','penerima')){
            Schema::table('orders', function (Blueprint $table) {
                $table->string('penerima')->nullable();
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['status_pembelian','no_faktur','supplier_do']);
        });
    }
}
