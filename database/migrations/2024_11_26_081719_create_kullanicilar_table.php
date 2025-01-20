<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKullanicilarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kullanicilar', function (Blueprint $table) {
            $table->id();
            $table->string('kullanici_adi');
            $table->string('sifre');
            $table->string('email')->unique();
            $table->string('konum')->nullable();
            $table->string('ilgi_alanlari')->nullable();
            $table->string('ad');
            $table->string('soyad');
            $table->date('dogum_tarihi');
            $table->string('cinsiyet');
            $table->string('telefon_numarasi')->nullable();
            $table->string('profil_fotografi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kullanicilar');
    }
}
