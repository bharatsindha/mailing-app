<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composes', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 50)->index();
            $table->string('email_id', 50)->index();
            $table->string('first_name', 25);
            $table->string('last_name', 25)->nullable();
            $table->string('to', 50)->index();
            $table->string('cc', 50)->nullable();
            $table->string('bcc', 50)->nullable();
            $table->string('designation', 50)->nullable();
            $table->string('project_name', 100)->nullable();
            $table->string('company_name', 50)->nullable();
            $table->tinyInteger('status')->default(0)->index()
                ->comment('0-not sent, 1-sent, 2-opened, 3-bounced');
            $table->dateTime('send_date')->nullable();
            $table->timestamps();
//            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('composes');
    }
};
