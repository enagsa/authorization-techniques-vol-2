<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Cookie\Middleware\EncryptCookies;

class ShowPostTest extends TestCase
{
    use RefreshDatabase;

    protected $post;

    public function setUp(): void{
        parent::setUp();
        $this->withoutExceptionHandling();

        $this->post = factory(Post::class)->create([
            'teaser' => 'The teaser',
            'content' => 'The content of the post'
        ]);
    }

    /** @test */
    function loggin_in_users_can_see_the_content_of_the_posts(){
        $this->actingAs($this->createUser());

        $response = $this->get($this->postUrl());

        $response->assertOk()
            ->assertViewIs('posts.show')
            ->assertSee('The teaser')
            ->assertSee('The content of the post');
    }

    /** @test */
    function anonymous_users_cannot_see_the_content_without_accepting_the_terms(){
        $this->get($this->postUrl())
            ->assertStatus(200)
            ->assertSee('The teaser')
            ->assertDontSee('The content of the post');
    }

    /** @test */
    function anonymous_users_can_see_the_content_if_the_have_accepted_the_terms(){
        //$this->withoutMiddleware(EncryptCookies::class);

        $this->call('GET', $this->postUrl(), [], ['accept_terms' => encrypt('1', false)])
            ->assertStatus(200)
            ->assertSee('The content of the post');
    }

    protected function postUrl(){
        return "posts/{$this->post->id}";
    }

    protected function withTermsAccepted(){
        return ['accept_terms' => encrypt('1', false)];
    }

    protected function withCookies(array $cookies){
        return new RequestWithCookies($this, $cookies);
    }
}
