<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTodosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project__todos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->required();
            $table->text('content')->requred();
            $table->unsignedBigInteger('user_id')->required();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('project_id')->required();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->boolean('status')->required();
            $table->dateTime('completion_date')->nullable();
            $table->date('due_date')->required();
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
        Schema::dropIfExists('project__todos');
    }
}
