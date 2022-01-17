<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->softDeletes();

            $table->string('title');
            $table->longText('overview')->nullable();
            $table->string('movie-url')->nullable();
            $table->integer('length')->nullable();
            $table->string('post-url')->nullable();
            $table->decimal('vote-average',2,1)->default(1);
            $table->date('release-date')->nullable();

            $table->foreignId('director_id')->nullable()->constrained('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
