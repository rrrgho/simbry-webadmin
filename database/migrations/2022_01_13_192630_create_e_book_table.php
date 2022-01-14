<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_book', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable();
            $table->integer('publisher_id')->nullable();
            $table->string('creator')->nullable();
            $table->string('edition')->nullable();
            $table->string('origin_book')->nullable();
            $table->string('buying_year')->nullable();
            $table->string('publish_year')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->string('link_pdf')->nullable();
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
        Schema::dropIfExists('e_book');
    }
}
