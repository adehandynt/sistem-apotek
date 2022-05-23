<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdHargaListPenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('item_penjualan','id_harga')){
            Schema::table('item_penjualan', function (Blueprint $table) {
                $table->string('id_harga')->nullable();
            });
        }

        if(!Schema::hasColumn('item_penjualan','harga_item')){
            Schema::table('item_penjualan', function (Blueprint $table) {
                $table->double('harga_item')->nullable();
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
        Schema::table('item_penjualan', function (Blueprint $table) {
            $table->dropColumn(['id_harga','harga_item']);
        });
    }
}
