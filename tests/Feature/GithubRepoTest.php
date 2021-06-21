<?php

namespace Tests\Feature;

use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Str;
use App\User;

/**
 * The Github Repositories class to test all the github functionalities 
 */
class GithubRepoTest extends TestCase
{

    /**
     * Test to check the security of the api url
     *
     * @return void
     */
    public function testApiGithubSecurityGuest()
    {

        $token = Str::random(20);

        $response = $this->withHeaders([
            'Accept' => 'application/json',
       ])->post('/api/getGithubStarRepos', ['gtoken' => $token]);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Unauthenticated.']);
    }

    /**
     * Test to check the response for a wrong github token
     *
     * @return void
     */
    public function testWrongGithubToken()
    {

        $token = Str::random(20);

        GitHub::shouldReceive('authenticate')
        ->once()
        ->andThrow('Exception','Bad credentials.',123456789);

        $user = factory(User::class)->make();

        $response = $this->withHeaders([
                        'Accept' => 'application/json',
                         ])
                         ->actingAs($user,'api')
                         ->withSession(['foo' => 'bar'])
                         ->post('/api/getGithubStarRepos', ['gtoken' => $token]);
        
        $response -> assertStatus(500)
                  ->assertJson(['error_message' => 'Bad credentials.']);
    }

    /**
     * Test to check the response for a right github token
     *
     * @return void
     */
    public function testRightGithubToken()
    {

        $token = Str::random(20);

        GitHub::shouldReceive('authenticate')
        ->once();

        $response['full_name'] = 'test';
        $response['html_url'] = 'http://test.url';

        GitHub::shouldReceive('api->starring->all')
        ->andReturn($response);

        $user = factory(User::class)->make();

        $response = $this->withHeaders([
                        'Accept' => 'application/json',
                         ])
                         ->actingAs($user,'api')
                         ->withSession(['foo' => 'bar'])
                         ->post('/api/getGithubStarRepos', ['gtoken' => $token]);

        $response -> assertStatus(200)
                  ->assertJson(['full_name' => 'test', 'html_url' => 'http://test.url']);
    }
}
