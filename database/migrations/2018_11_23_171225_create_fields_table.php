<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'title', 255 );
            $table->string( 'key', 255 )->unique();
            $table->enum('type', config('app.field_type'))->default("string");
            $table->timestamps();
        });

         // -- Insert default recods.
        DB::table('fields')->insert(
            [
              [
                "title" => "Name",
                "key" => "name",
                "type" => "string",
              ],
              [
                "title" => "Email",
                "key" => "email",
                "type" => "string",
              ],
              [
                "title" => "DOB",
                "key" => "dob",
                "type" => "date",
              ],
              [
                "title" => "Age",
                "key" => "age",
                "type" => "number",
              ],
              [
                "title" => "Company",
                "key" => "company",
                "type" => "string",
              ],
              [
                "title" => "Is MailerLite Developer",
                "key" => "is_mailerlite_developer",
                "type" => "boolean",
              ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
}
