<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesajlarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesajlar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gonderici_id')->constrained('kullanicilar')->onDelete('cascade');
            $table->foreignId('alici_id')->constrained('kullanicilar')->onDelete('cascade');
            $table->text('mesaj_metni');
            $table->timestamp('gonderim_zamani')->useCurrent();
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
        Schema::dropIfExists('mesajlar');
    }
}
