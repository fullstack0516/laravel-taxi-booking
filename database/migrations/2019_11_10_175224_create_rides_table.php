<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('owner_id')->unsigned()->index();
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('ride_type_id')->unsigned()->index();
            $table->foreign('ride_type_id')->references('id')->on('ride_types')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->integer('seats')->default(1);
            $table->string('address_from')->nullable();
            $table->point('location_from')->nullable();
            $table->string('address_to')->nullable();
            $table->point('location_to')->nullable();
            $table->float('price_min')->default(0.0);
            $table->float('price_max')->default(0.0);
            $table->dateTime('time_from')->nullable();
            $table->dateTime('time_to')->nullable();
            $table->text('description')->nullable();
            $table->string('file_path')->nullable();
            $table->unsignedBigInteger('driver_id')->unsigned()->nullable();
            $table->foreign('driver_id')->references('id')->on('users')->onDelete('set null');
            $table->float('accepted_salary')->default(0.0);
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('completed_at')->nullable();
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
        Schema::dropIfExists('rides');
    }
}
