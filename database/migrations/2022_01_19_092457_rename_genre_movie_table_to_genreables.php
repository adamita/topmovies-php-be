<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameGenreMovieTableToGenreables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('genre_movie', function (Blueprint $table) {
            $table->dropForeign('genre_movie_movie_id_foreign');
            $table->dropColumn('movie_id');
        });

        Schema::rename('genre_movie','genreables');

        Schema::table('genreables', function (Blueprint $table) {
            $table->morphs('genreable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('genreables', function (Blueprint $table) {
            $table->dropMorphs('genreable');
        });

        Schema::rename('genreables','genre_movie');

        Schema::disableForeignKeyConstraints();

        Schema::table('genre_movie', function (Blueprint $table) {
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }
}
