<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book', function (Blueprint $table) {
            $table->id();
            $table->integer('creator_id');
            $table->integer('publisher_id');
            $table->integer('edition_id');
            $table->integer('locker_id');
            $table->string('origin_book');
            $table->integer('book_number');
            $table->dateTime('buying_year');
            $table->dateTime('publish_year');
            $table->string('call_number')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('cover')->nullable();
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
        Schema::dropIfExists('book');
    }
}
