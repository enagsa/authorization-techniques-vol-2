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
    function admins_can_see_all_posts(){
        $post1 = factory(Post::class)->create();
        $post2 = factory(Post::class)->create();

        $this->actingAs($this->createAdmin());

        $response = $this->get('admin/posts');

        $response->assertStatus(200)
            ->assertViewIs('admin.posts.index')
            ->assertViewHas('posts', function($posts) use($post1, $post2){
                return $posts->contains($post1)
                    && 
                    $posts->contains($post2);
            });
    }

    /** @test */
    function authors_can_only_see_their_posts(){
        $user = $this->createUser();

        $post1 = factory(Post::class)->create([
            'user_id' => $user->id]
        );
        $post2 = factory(Post::class)->create();
        $post3 = factory(Post::class)->create([
            'user_id' => $user->id]
        );
        $post4 = factory(Post::class)->create();

        $this->actingAs($user);

        $response = $this->get('admin/posts');

        $response->assertStatus(200)
            ->assertViewIs('admin.posts.index')
            ->assertViewHas('posts', function($posts) use($post1, $post2, $post3, $post4){
                return $posts->contains($post1)
                    && 
                    !$posts->contains($post2)
                    &&
                    $posts->contains($post3)
                    &&
                    !$posts->contains($post4);
            });
    }
}
