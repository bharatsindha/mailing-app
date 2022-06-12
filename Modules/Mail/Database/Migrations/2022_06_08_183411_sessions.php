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
            $table->integer('domain_id')->index();
            $table->integer('email_id')->index();
            $table->integer('user_id')->index();
//            $table->string('session_id', 50);
            $table->string('subject');
            $table->text('mail_content');
            $table->integer('total_emails')->default(0);
            $table->integer('total_sent')->default(0);
            $table->integer('total_opened')->default(0);
            $table->integer('total_bounced')->default(0);
            $table->tinyInteger('is_completed')->default(0)->index()
                ->comment('0-yet to start, 1-in process, 2-completed');
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
        Schema::dropIfExists('sessions');
    }
};
