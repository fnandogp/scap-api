<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRemovalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('removal_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('type');
            $table->string('status');

            $table->timestamp('removal_from')->nullable();
            $table->timestamp('removal_to')->nullable();
            $table->text('removal_reason');

            $table->string('onus');

            $table->string('event');
            $table->string('city');
            $table->timestamp('event_from')->nullable();
            $table->timestamp('event_to')->nullable();

            $table->integer('rapporteur_id')->unsigned()->nullable();
            $table->foreign('rapporteur_id')->references('id')->on('users');

            $table->timestamp('judgment_at')->nullable();

            $table->timestamp('canceled_at')->nullable();
            $table->text('cancellation_reason')->nullable();

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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('removal_requests');
        Schema::enableForeignKeyConstraints();
    }
}
