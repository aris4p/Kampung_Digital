<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWilayahToWargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wargas', function (Blueprint $table) {

            $table->string('provinsi')->after('nik');
            $table->string('kota')->after('provinsi');
            $table->string('kecamatan')->after('kota');
            $table->string('kelurahan')->after('kecamatan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wargas', function (Blueprint $table) {

            $table->dropColumn('provinsi');
            $table->dropColumn('kota');
            $table->dropColumn('kecamatan');
            $table->dropColumn('kelurahan');
        });
    }
}
