<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

class UserTest extends TestCase
{
    public function testGetUserInfo() {
        $user = User::find(1);

        $response = $this->actingAs($user, "api")->getJson("/api/user/profile");

        $response->assertJson(function (AssertableJson $json) use ($user) { 
            return $json->where('success', true)
                ->where('message', "Usuário recuperado")
                ->where("data.id", 1)
                ->where("data.name", $user->name)
                ->where("data.email", $user->email)
                ->where("data.culinary_level", $user->profile->culinary_level)
                ->where("data.gender", $user->profile->gender)
                ->where("data.photo", $user->profile->photo);
            }
        );
    }

    public function testGetNewUserInfo() {
        $user = User::factory()->create();

        $response = $this->actingAs($user, "api")->getJson("/api/user/profile");

        $response->assertJson(function (AssertableJson $json) use ($user) { 
            return $json->where('success', true)
                ->where('message', "Usuário recuperado")
                ->where("data.id", $user->id)
                ->where("data.name", $user->name)
                ->where("data.email", $user->email)
                ->missing("data.culinary_level")
                ->missing("data.gender")
                ->missing("data.photo");
            }
        );
    }
}
