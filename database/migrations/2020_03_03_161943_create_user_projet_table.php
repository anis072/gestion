<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProjetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_projet', function (Blueprint $table) {
            $table->bigIncrements('id');

        $table->unsignedBigInteger('projet_id');
        $table->foreign('projet_id')->references('id')->on('projets')->onDelete('cascade');
        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->string('membre')->nullbale();
        $table->string('name')->nullable();
        $table->string('durre')->nullable();
        $table->text('description')->nullable();
        $table->string('owner')->nullable();
        $table->string('budget')->nullable();
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
        Schema::dropIfExists('user_projet');
    }
}
