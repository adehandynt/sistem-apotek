<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiskonJasa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('list_jasa','diskon_jasa')){
            Schema::table('list_jasa', function (Blueprint $table) {
                $table->double('diskon_jasa')->default('0');
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
        Schema::table('list_jasa', function (Blueprint $table) {
            $table->dropColumn(['diskon_jasa']);
        });
    }
}
