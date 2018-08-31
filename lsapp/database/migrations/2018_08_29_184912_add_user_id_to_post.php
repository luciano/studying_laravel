<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToPost extends Migration
{
    /**
     * Run the migrations and it will be add to the table
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function($table) {
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations. Use rollback will delete the id
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function($table) {
            $table->dropColunm('user_id');
        });
    }
}
