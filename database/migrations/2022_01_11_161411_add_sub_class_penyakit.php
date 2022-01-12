<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubClassPenyakit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('penyakit','sub_class')){
            Schema::table('penyakit', function (Blueprint $table) {
                $table->string('sub_class');
            });
        }

        if(!Schema::hasColumn('penyakit','parent_class')){
            Schema::table('penyakit', function (Blueprint $table) {
                $table->string('parent_class');
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
        Schema::table('penyakit', function (Blueprint $table) {
            $table->dropColumn(['parent_class','sub_class']);
        });
    }
}
