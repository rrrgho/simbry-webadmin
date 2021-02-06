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
            $table->integer('category_id')->nullable();
            $table->integer('publisher_id')->nullable();
            $table->integer('locker_id')->nullable();
            $table->string('book_number')->nullable();
            $table->string('creator')->nullable();
            $table->string('edition')->nullable();
            $table->string('origin_book')->nullable();
            $table->integer('queue_of_examplar')->nullable();
            $table->string('examplar')->nullable();
            $table->string('code_of_book')->nullable();
            $table->string('buying_year')->nullable();
            $table->string('publish_year')->nullable();
            $table->string('call_number')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
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
