<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerpusBuku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpus_buku', function (Blueprint $table) {
            $table->id();
            $table->string('kode_buku', 64)->nullable();
            $table->string('judul', 128);
            $table->string('pengarang', 128);
            $table->unsignedBigInteger('penerbit_id')->nullable(); // nama_penerbit
            $table->foreign('penerbit_id')->references('id')->on('perpus_penerbit');
            $table->year('thn_terbitan')->nullable();
            $table->date('tgl_masuk')->nullable();
            $table->unsignedBigInteger('kategori_id')->nullable(); // kategori
            $table->foreign('kategori_id')->references('id')->on('perpus_kategori_buku');
            $table->unsignedBigInteger('rak_id')->nullable(); // rak
            $table->foreign('rak_id')->references('id')->on('perpus_rak');
            $table->double('jml_buku')->default(0);
            $table->double('stock_master')->default(0);
            $table->string('foto', 64)->nullable();
            $table->string('barcode', 64)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perpus_buku');
    }
}
