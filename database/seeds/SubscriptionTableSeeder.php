<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class SubscriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::first();
        if( empty( $user ) ){
            $user_id = factory(App\User::class)->create(['email' => "admin@mailerlite.com"])->id;
        } else {
            $user_id = $user->id;
        }

        factory(App\Models\Subscription::class, 3)->create([ 'user_id' => $user_id ])->each(function($s){

            // -- Name
            $s->fields()->save(factory(App\Models\SubscriptionField::class)->make([
                "value" => $s->name,
                "key" => 'name'
            ]));
            // -- Email
            $s->fields()->save(factory(App\Models\SubscriptionField::class)->make([
                'key' => "email",
                "value" => $s->email
            ]));
        });
    }
}
