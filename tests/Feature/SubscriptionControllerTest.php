<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Subscription;
use App\Models\SubscriptionField;
use App\User;

class SubscriptionControllerTest extends TestCase
{

	use RefreshDatabase;

    public function testSubscriberListing()
    {
        $user = factory(User::class)->create(['email' => "admin@mailerlite.com"]);
        $user->generateToken();
        factory(Subscription::class)->create([ 'user_id' => $user->id ])->each(function($s){

            // -- Name
            $s->fields()->save(factory(SubscriptionField::class)->make([
                "value" => $s->name,
                "key" => 'name'
            ]));
            // -- Email
            $s->fields()->save(factory(SubscriptionField::class)->make([
                'key' => "email",
                "value" => $s->email
            ]));
        });

        $response = $this->actingAs($user, 'api')->json('GET', 'api/v1/subscriber/list');
        
        $response->assertStatus(200);
        
        $data = json_decode($response->getContent(), 1);

        $this->assertCount(1, $data[ 'data' ]);
    }


    public function testGetSingleSubscription()
    {
        $user = factory(User::class)->create(['email' => "admin@mailerlite.com"]);
        $user->generateToken();
        factory(Subscription::class)->create([ 'user_id' => $user->id ])->each(function($s){

            // -- Name
            $s->fields()->save(factory(SubscriptionField::class)->make([
                "value" => $s->name,
                "key" => 'name'
            ]));
            // -- Email
            $s->fields()->save(factory(SubscriptionField::class)->make([
                'key' => "email",
                "value" => $s->email
            ]));
        });

        $subscription = Subscription::first();

        $response = $this->actingAs($user, 'api')->json('GET', '/api/v1/subscriber/' . $subscription->id);

        
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), 1);
        $this->assertEquals($data[ 'id' ], $subscription->id);
    }


    public function testStoreSingleSubscription()
    {
        $user = factory(User::class)->create(['email' => "admin@mailerlite.com"]);
        $user->generateToken();

        $response = $this->actingAs($user, 'api')->json('POST', '/api/v1/subscriber',
        [
        	"name" => "Abhijeet Bagul",
        	"email" => "abhijeet.bagul@gmail.com",
        	"state" => "active",
        	"fields" => [
                "name"=>"Abhijeet Bagul","email"=>"abhijeet.bagul@gmail.com"
            ]
        ]);
        
        $response->assertStatus(201);
        $this->assertArrayHasKey('id', json_decode($response->getContent(),1));

        $response = $this->actingAs($user, 'api')->json('POST', '/api/v1/subscriber',
        [
        	"name" => "Abhijeet Bagul",
        	"email" => "abhijeet.bagul@gmail.com",
        	"state" => "active"
        ]);

        $response->assertStatus(422);


    }


    public function testDeleteSingleSubscription()
    {
        $user = factory(User::class)->create(['email' => "admin@mailerlite.com"]);
        $user->generateToken();
        factory(Subscription::class)->create([ 'user_id' => $user->id ])->each(function($s){

            // -- Name
            $s->fields()->save(factory(SubscriptionField::class)->make([
                "value" => $s->name,
                "key" => 'name'
            ]));
            // -- Email
            $s->fields()->save(factory(SubscriptionField::class)->make([
                'key' => "email",
                "value" => $s->email
            ]));
        });

        $subscription = Subscription::first();

        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/v1/subscriber/' . $subscription->id);

        $response->assertStatus(201);
    }


    public function testUpdSinategleSubscription()
    {
        $user = factory(User::class)->create(['email' => "admin@mailerlite.com"]);
        $user->generateToken();
        factory(Subscription::class)->create([ 'user_id' => $user->id ])->each(function($s){

            // -- Name
            $s->fields()->save(factory(SubscriptionField::class)->make([
                "value" => $s->name,
                "key" => 'name'
            ]));
            // -- Email
            $s->fields()->save(factory(SubscriptionField::class)->make([
                'key' => "email",
                "value" => $s->email
            ]));
        });

        $subscription = Subscription::first();

        $new_name = "Abhijeet Bagul";
        $response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/subscriber/' . $subscription->id,[
            "name" => $new_name,
            "email" => $subscription->email,
            "fields" => [
                "name"=>$new_name,"email"=>$subscription->email
            ]
        ]);

       $response->assertStatus(200);
        $resp_data = json_decode($response->getContent(),1);
        $this->assertEquals($new_name, $resp_data['name']);

        // -- duplication check
        $response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/subscriber/' . $subscription->id,[
            "name" => $new_name,
            "email" => "",
            "fields" => [
                "name"=>$new_name,"email"=>$subscription->email
            ]
        ]);

        $response->assertStatus(422);
    }
}
