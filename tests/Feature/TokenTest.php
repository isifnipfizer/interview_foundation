<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Str;
use App\User;

class TokenTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTokenAdd()
    {
        $user = factory(User::class)->make();

        $token = Str::random(20);

        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->post('/addToken', ['gtoken' => $token]);

        $response->assertStatus(200)
                 ->assertJson(['gtoken' => $token]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTokenAddWithoutToken()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->post('/addToken');

        $errors = session('errors');

        $response->assertSessionHasErrors();

        $this->assertEquals($errors->get('gtoken')[0],"The gtoken field is required.");
    }
}
