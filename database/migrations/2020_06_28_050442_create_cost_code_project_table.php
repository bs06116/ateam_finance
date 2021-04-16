<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostCodeProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if ( !Schema::hasTable('cost_code_project') ) {
            Schema::create('cost_code_project', function (Blueprint $table) {
                $table->unsignedInteger('project_id');
                $table->foreign('project_id', 'project_id_fk_1357514')->references('id')->on('projects')->onDelete('cascade');
                $table->unsignedInteger('cost_code_id');
                $table->foreign('cost_code_id', 'cost_code_id_fk_1357554')->references('id')->on('cost_codes')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cost_code_project');
    }
}
