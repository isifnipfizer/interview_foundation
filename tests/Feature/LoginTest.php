<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

/**
 * The Login class to test all the login/logout functionalities 
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Check if a guest redirects to login.
     *
     * @return void
     */
    public function testUserNotLoggedIn()
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    /**
     * Check if a logged in user goes to home page
     *
     * @return void
     */
    public function testUserLoggedIn()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->get('/');

        $response->assertOk();

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Check if a logged in user log out.
     *
     * @return void
     */
    public function testUserLogout()
    {
        $user = factory(User::class)->make();

        $response = $this->actingAs($user)
                         ->withSession(['foo' => 'bar'])
                         ->post('/logout');

        $response->assertRedirect('/');

        $this->assertGuest();
    }
}
