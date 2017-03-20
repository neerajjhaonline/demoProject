<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditing',function(Blueprint $table){
            $table->increments('id');
            $table->string('rfi_description');
            $table->mediumInteger('total_lane');
            $table->mediumInteger('no_of_lane');
            $table->boolean('markError');
            $table->string('root_cause');
            $table->string('correction');
            $table->string('corrective_action');
            $table->string('preventive_action');
            //$table->string('error_description');
            $table->dateTime('proposed_comp_dt');
            $table->dateTime('proposed_act_dt');

            $table->dateTime('audit_start_dt');
            $table->dateTime('audit_end_dt');
            $table->dateTime('rfi_start_dt');
            $table->dateTime('rfi_end_dt');
            
            $table->dateTime('tat');


            $table->integer('publishing_id')->unsigned()->nullable();
            $table->foreign('publishing_id')->references('id')->on('process_queue')->onDelete('cascade');

            $table->integer('request_id')->unsigned()->nullable();
            $table->foreign('request_id')->references('id')->on('mst_request_type')->onDelete('cascade');

            $table->integer('container_id')->unsigned()->nullable();
            $table->foreign('container_id')->references('id')->on('mst_container_type')->onDelete('cascade');

            $table->integer('publish_by')->unsigned()->nullable();
            $table->foreign('publish_by')->references('id')->on('mst_user_access')->onDelete('cascade');

            $table->integer('status_id')->unsigned()->nullable();
            $table->foreign('status_id')->references('id')->on('mst_status')->onDelete('cascade');
            
            //$table->string('mode_id');
            $table->boolean('oot');
            $table->string('oot_remark');
            $table->string('comment');
           
          
            $table->integer('rfiType_id')->unsigned()->nullable();
            $table->foreign('rfiType_id')->references('id')->on('mst_rfiType')->onDelete('cascade');

            $table->integer('query_raised_by')->unsigned()->nullable();
            $table->foreign('query_raised_by')->references('id')->on('mst_user_access')->onDelete('cascade');

            $table->integer('audit_by')->unsigned()->nullable();
            $table->foreign('audit_by')->references('id')->on('mst_user_access')->onDelete('cascade');

            $table->integer('error_cat_id')->unsigned()->nullable();
            $table->foreign('error_cat_id')->references('id')->on('mst_error_cat')->onDelete('cascade');

            $table->integer('error_type_id')->unsigned()->nullable();
            $table->foreign('error_type_id')->references('id')->on('mst_error_type')->onDelete('cascade');
            
            $table->integer('error_done_by')->unsigned()->nullable();
            $table->foreign('error_done_by')->references('id')->on('mst_user_access')->onDelete('cascade');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });

    

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('auditing');
    }
}
