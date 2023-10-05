<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->increments('id')->unique(); //id menjadi AI type unik
            $table->char('id_kategori', 15); //kolom id_kategori type char(10)
            $table->string('nama_kategori'); //string utk varchar
            $table->timestamps();
        });
        Schema::table('kategoris', function ($table){
            $table->dropPrimary('id'); //hapus PK dari id
            $table->primary('id_kategori'); //menjadikan PK
        });
  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kategoris');
    }
};
