<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('receiver_type', 32)->nullable(); // ALL | USER
            $table->integer('receiver_id')->default(0);
            $table->string('status', 32)->default(\Boykioyb\Notify\Services\Common\Notify::STATUS_PENDING); // PENDING | APPROVED | SUCCESS
            $table->string('action', 32)->nullable(); // LINK | TRANSACTION | PROFILE | USER_VERIFY
            $table->text('content')->nullable(); // URL | PAYMENT ID | x | x
            $table->text('send_data')->nullable();
            $table->string('creator_type', 32)->nullable();
            $table->integer('creator_id')->default(0);
            $table->integer('moderator_id')->default(0);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
