<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('mst_access',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('mst_user_access',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->string('loginId');
            $table->integer('access_id')->unsigned()->nullable();
            $table->foreign('access_id')->references('id')->on('mst_access')->onUpdate('cascade')->onDelete('cascade');
            $table->string('email');
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
         Schema::drop('mst_access');
         Schema::drop('mst_user_access');
    }
}
