<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoteCountToMoviesAndTopMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->integer('vote_count')->default(0);
        });

        Schema::table('top_movies', function (Blueprint $table) {
            $table->integer('vote_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('vote_count');
        });

        Schema::table('top_movies', function (Blueprint $table) {
            $table->dropColumn('vote_count');
        });
    }
}
