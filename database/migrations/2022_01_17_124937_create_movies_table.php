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
            $table->string('movie_url')->nullable();
            $table->integer('runtime')->nullable();
            $table->string('poster_path')->nullable();
            $table->decimal('vote_average',3,1)->default(1);
            $table->date('release_date')->nullable();

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
