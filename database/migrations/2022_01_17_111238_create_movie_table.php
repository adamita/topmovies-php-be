<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('title');
            $table->longText('overview');
            $table->string('movie-url');
            $table->integer('length');
            $table->string('post-url');
            $table->decimal('vote-average',2,1);
            $table->date('release-date');

            $table->foreignId('director_id')->constrained('person')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie');
    }
}
