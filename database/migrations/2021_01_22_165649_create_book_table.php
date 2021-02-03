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
            $table->integer('category_id');
            $table->integer('publisher_id');
            $table->integer('edition_id');
            $table->integer('locker_id');
            $table->string('origin_book');
            $table->integer('book_number');
            $table->integer('queue_of_examplar');
            $table->string('examplar');
            $table->string('code_of_book');
            $table->date('buying_year');
            $table->date('publish_year');
            $table->string('call_number');
            $table->string('name');
            $table->text('description');
            $table->string('cover')->nullable();
            $table->boolean('ready')->default(true); // Buat false jika sedang dipinjam
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
