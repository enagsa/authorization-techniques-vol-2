<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListPostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authenticated_users_can_view_posts(){
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->create();

        $this->actingAs($this->createUser());

        $response = $this->get('admin/posts');

        $response->assertStatus(200)
            ->assertViewIs('admin.posts.index')
            ->assertViewHas('posts', function($posts) use($post1, $post2){
                return $posts->contains($post1)
                    && 
                    $posts->contains($post2);
            });
    }
}
