<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('composes', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 50);
            $table->string('receiver_email', 50);
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->string('designation', 50);
            $table->string('company', 50);
            $table->string('curl', 50);
            $table->string('project', 100);
            $table->tinyInteger('status')->default(0)
                ->comment('0-not sent, 1-sent, 2-opened, 3-bounced');
            $table->timestamps();
            $table->softDeletes();
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
