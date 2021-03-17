<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide_banner', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('images')->nullable();
            $table->boolean('active')->default(false); // Buat true jika sedang aktif slide
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
        Schema::dropIfExists('slide_banner');
    }
}
