<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indexing',function(Blueprint $table){
            $table->increments('id');
            $table->dateTime('mail_received_dt');
            $table->dateTime('tat_after_index');
            $table->string('request_no');
            $table->string('cust_name');
            $table->integer('priority_id')->unsigned()->nullable();
            $table->foreign('priority_id')->references('id')->on('mst_priority_type')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('region_id')->unsigned()->nullable();
            $table->foreign('region_id')->references('id')->on('mst_region')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('req_type_id')->unsigned()->nullable();
            $table->foreign('req_type_id')->references('id')->on('mst_request_type')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('cont_type_id')->unsigned()->nullable();
            $table->foreign('cont_type_id')->references('id')->on('mst_container_type')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('office_id')->unsigned()->nullable();
            $table->foreign('office_id')->references('id')->on('mst_office')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('indexed_by')->nullable();
            
            $table->softDeletes();
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
        Schema::drop('indexing');
    }
}
