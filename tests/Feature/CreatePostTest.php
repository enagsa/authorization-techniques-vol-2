<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admins_can_create_posts(){
        //$this->withoutExceptionHandling();
        $this->actingAs($admin = $this->createAdmin());

        $this->get('admin/posts/create')
            ->assertSuccessful()
            ->assertSee('New post');

        $this->post('admin/posts', [
                'title' => 'New post'
            ])
            ->assertStatus(201)
            ->assertSee('Post created');

        tap(Post::first(), function($post){
            $this->assertNotNull($post);
            $this->assertSame('New post', $post->title);
        });
    }

    /** @test */
    function authors_can_create_posts(){
        $this->actingAs($user = $this->createUser());
        $user->assign('author');

        $this->get('admin/posts/create')
            ->assertSuccessful()
            ->assertSee('New post');

        $this->post('admin/posts', [
                'title' => 'New post'
            ])
            ->assertStatus(201)
            ->assertSee('Post created');

        $this->assertDatabaseHas('posts', [
            'title' => 'New post'
        ]);
    }

    /** @test */
    function unauthorized_users_cannot_create_posts(){
        $this->actingAs($user = $this->createUser());

        $this->get('admin/posts/create')
            ->assertStatus(403);

        $this->post('admin/posts', [
                'title' => 'New post'
            ])
            ->assertStatus(403);

        $this->assertDatabaseEmpty('posts');
    }
}
