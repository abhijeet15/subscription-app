<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Field;
use App\User;

class FieldControllerTest extends TestCase
{

	use RefreshDatabase;

    public function testGetAllFields()
    {
        $user = factory(User::class)->create(['email' => "admin@mailerlite.com"]);
        $user->generateToken();

        $response = $this->actingAs($user, 'api')->json('GET', 'api/v1/field/list');
        // print_r(json_decode($response->getContent(),1));die;
        $response->assertStatus(200);
        $this->assertContains(
            [
                "id" => "1",
                "title" => "Name",
                "key" => "name",
                "type" => "string"

            ]
        , json_decode($response->getContent(),1));
    }
}
