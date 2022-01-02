<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusSinkronasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('list_opname','status_sinkronasi')){
            Schema::table('list_opname', function (Blueprint $table) {
                $table->integer('status_sinkronasi')->default('0');
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
            $table->dropColumn(['status_sinkronasi']);
        });
    }
}
