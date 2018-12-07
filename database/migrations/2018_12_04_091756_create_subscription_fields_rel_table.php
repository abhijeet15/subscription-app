<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionFieldsRelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer( 'subscription_id' );
            $table->string( 'key', 255 );//-- Foriegn key - feilds.key
            $table->string( 'value', 255 )->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_fields');
    }
}
