<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ride_id')->unsigned()->index();
            $table->foreign('ride_id')->references('id')->on('rides')->onDelete('cascade');
            $table->unsignedBigInteger('driver_id')->unsigned()->index();
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('cascade');
            $table->float('price')->default(0.0);
            $table->text('description')->nullable();
            $table->string('attach_file')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('paid_at')->nullable();
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
        Schema::dropIfExists('bids');
    }
}
