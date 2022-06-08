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
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('email_id');
            $table->integer('user_id');
            $table->string('session_id', 50);
            $table->string('list_name');
            $table->string('subject');
            $table->text('mail_content');
            $table->integer('total_emails')->default(0);
            $table->integer('total_sent')->default(0);
            $table->integer('total_opened')->default(0);
            $table->integer('total_bounced')->default(0);
            $table->tinyInteger('is_completed')->default(0)
                ->comment('0-yet to start, 1-in process, 2-completed');
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
        Schema::dropIfExists('sessions');
    }
};
