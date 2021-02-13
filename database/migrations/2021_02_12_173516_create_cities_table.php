<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('country_code', 2)->index(); //ISO 3166-1 alpha-2
            $table->string('name', 255)->unique()->index();
            $table->json('current_response')->nullable();
            $table->json('forecast_response')->nullable();
            $table->timestamp('current_updated_at')->nullable();
            $table->timestamp('forecast_updated_at')->nullable();

            //Foreign keys
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
}
