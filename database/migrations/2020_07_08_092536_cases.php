<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('supportteam_id')->nullable();
            $table->string('status',100)->nullable();
            $table->string('tomail',150)->nullable();
            $table->string('subject',50)->nullable();
            $table->text('casetext')->nullable();
            $table->string('itResponse',255)->nullable();
            $table->string('itResponsePerson',150)->nullable();
            $table->integer('itResponseRead')->nullable();
            $table->string('room',50)->nullable();
            $table->string('phone',50)->nullable();
            $table->integer('requestUser')->nullable();
            $table->string('ipAddress',50)->nullable();
            $table->string('stacked_to',100)->nullable();
            $table->string('accepted_by',100)->nullable();
            $table->tinyInteger('hasNewMessage');
            $table->tinyInteger('hasNewMessageIt');

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
        Schema::dropIfExists('cases');
    }
}
