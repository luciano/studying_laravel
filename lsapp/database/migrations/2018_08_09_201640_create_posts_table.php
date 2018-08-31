<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // when run DB migrate, create posts table
        Schema::create('posts', function (Blueprint $table) {
            // create id field primary key
            $table->increments('id');

            // creating fields of the table
            $table->string('title');
            $table->mediumText('body');

            // create two timestamps for create and updated and it is automatically fill
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
        Schema::dropIfExists('posts');
    }
}
