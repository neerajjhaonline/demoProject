<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessQueue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mst_status_cat',function(Blueprint $table){
            $table->increments('id');
            $table->string('statusCat_name');
            $table->timestamps();
        });

        Schema::create('mst_status',function(Blueprint $table){
            $table->increments('id');
            $table->integer('statusCatId')->unsigned()->nullable();
            $table->foreign('statusCatId')->references('id')->on('mst_status_cat')->onUpdate('cascade')->onDelete('cascade');
            $table->string('status_name');
            $table->timestamps();
        });

              
        Schema::create('mst_commodity',function(Blueprint $table){
            $table->increments('id');
            $table->string('type');
            $table->string('commodity_name');
            $table->string('description');
            $table->timestamps();
        });    

        Schema::create('mst_rfiType',function(Blueprint $table){
            $table->increments('id');
            $table->string('rfiType_name');
            $table->timestamps();
        });

        Schema::create('process_queue',function(Blueprint $table){
            $table->increments('id');
            $table->string('rfi_description');
            $table->mediumInteger('total_lane');
            $table->mediumInteger('no_of_lane');
            $table->string('root_cause');
            $table->string('correction');
            $table->string('corrective_action');
            $table->string('preventive_action');
            //$table->string('error_description');
            $table->dateTime('proposed_comp_dt');
            $table->dateTime('proposed_act_dt');

            $table->dateTime('publish_start_dt');
            $table->dateTime('publish_end_dt');
            $table->dateTime('rfi_start_dt');
            $table->dateTime('rfi_end_dt');
            $table->dateTime('tat');


            $table->integer('indexing_id')->unsigned()->nullable();
            $table->foreign('indexing_id')->references('id')->on('indexing')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('request_id')->unsigned()->nullable();
            $table->foreign('request_id')->references('id')->on('mst_request_type')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('container_id')->unsigned()->nullable();
            $table->foreign('container_id')->references('id')->on('mst_container_type')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('publish_by')->unsigned()->nullable();
            $table->foreign('publish_by')->references('id')->on('mst_user_access')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('mst_status')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('commodity_id')->unsigned()->nullable();
            $table->foreign('commodity_id')->references('id')->on('mst_commodity')->onUpdate('cascade')->onDelete('cascade');

            $table->string('mode_id');
            $table->boolean('oot');
            $table->string('oot_remark');
            $table->string('comment');
           
          
            $table->integer('rfiType_id')->unsigned()->nullable();
            $table->foreign('rfiType_id')->references('id')->on('mst_rfiType')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('query_raised_by')->unsigned()->nullable();
            $table->foreign('query_raised_by')->references('id')->on('mst_user_access')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('error_cat_id')->unsigned()->nullable();
            $table->foreign('error_cat_id')->references('id')->on('mst_error_cat')->onUpdate('cascade')->onDelete('cascade');

            $table->integer('error_type_id')->unsigned()->nullable();
            $table->foreign('error_type_id')->references('id')->on('mst_error_type')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('process_status_id')->unsigned()->nullable();
            $table->foreign('process_status_id')->references('id')->on('mst_status')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('error_done_by')->unsigned()->nullable();
            $table->foreign('error_done_by')->references('id')->on('mst_user_access')->onUpdate('cascade')->onDelete('cascade');
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
        
         Schema::drop('mst_status');
         Schema::drop('mst_status_cat');
         Schema::drop('statusCatId_statusId');
         Schema::drop('mst_commodity');
         Schema::drop('process_queue');
          
    }
}
