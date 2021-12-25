<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateNotificationRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('notification_id')->nullable()->default(0);
            $table->integer('device_id')->nullable()->default(0);
            $table->integer('user_id')->nullable()->default(0);
            $table->string('status', 32)->nullable(); // PENDING | PROCESSING | SUCCESS
            $table->boolean('is_read')->default(0);
            $table->text('meta_data')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->index(['notification_id']);
            $table->index(['user_id']);
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
        Schema::dropIfExists('notification_records');
    }
}
