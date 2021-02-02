<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author_id')->unsigned()->index();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id')->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('driver_id')->unsigned()->nullable();
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('ride_id')->unsigned()->nullable();
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('set null');
            $table->unsignedBigInteger('bid_id')->unsigned()->nullable();
            $table->foreign('bid_id')->references('id')->on('bids')->onDelete('set null');
            $table->integer('rating')->default(0);
            $table->tinyInteger('on_time')->default(0);
            $table->tinyInteger('on_budget')->default(0);
            $table->text('comments')->nullable();
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
        Schema::dropIfExists('reviews');
    }
}
