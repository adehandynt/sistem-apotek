<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRekamMedis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('rekam_medis','nadi')){
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->text('nadi')->nullable();
            });
        }
        if(!Schema::hasColumn('rekam_medis','suhu')){
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->text('suhu')->nullable();
            });
        }
        if(!Schema::hasColumn('rekam_medis','anamnesa')){
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->text('anamnesa')->nullable();
            });
        }
        if(!Schema::hasColumn('rekam_medis','fisik')){
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->text('fisik')->nullable();
            });
        }
        if(!Schema::hasColumn('rekam_medis','penunjang')){
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->text('penunjang')->nullable();
            });
        }

        if(!Schema::hasColumn('rekam_medis','terapi')){
            Schema::table('rekam_medis', function (Blueprint $table) {
                $table->text('terapi')->nullable();
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
        Schema::table('rekam_medis', function (Blueprint $table) {
            $table->dropColumn(['nadi','suhu','anamnesa','fisik','penunjang','terapi']);
        });
    }
}
