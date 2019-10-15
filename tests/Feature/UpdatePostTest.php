<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admins_can_update_posts(){
        $post = factory(Post::class)->create();
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->put('admin/posts/'.$post->id, [
            'title' => 'Updated post title'
        ]);

        $response->assertStatus(200)
            ->assertSee('Post updated!');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }

    /** @test */
    function authors_can_update_posts_they_own(){
        $user = $this->createUser();
        $user->assign('author');

        $post = factory(Post::class)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        $response = $this->put('admin/posts/'.$post->id, [
            'title' => 'Updated post title'
        ]);

        $response->assertStatus(200)
            ->assertSee('Post updated!');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }

    /** @test */
    function authors_can_update_posts_they_dont_own(){
        $user = $this->createUser();
        $user->assign('author');

        $post = factory(Post::class)->create();

        $this->actingAs($user);

        $response = $this->put('admin/posts/'.$post->id, [
            'title' => 'Updated post title'
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }

    /** @test */
    function editors_can_update_posts(){
        $user = $this->createUser();
        $user->assign('editor');

        $post = factory(Post::class)->create();

        $this->actingAs($user);

        $response = $this->put('admin/posts/'.$post->id, [
            'title' => 'Updated post title'
        ]);

        $response->assertStatus(200)
            ->assertSee('Post updated!');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }

    /** @test */
    function unnauthorized_users_cannot_update_posts(){
        $post = factory(Post::class)->create();
        $user = $this->createUser();

        $this->actingAs($user);

        $response = $this->put('admin/posts/'.$post->id, [
            'title' => 'Updated post title'
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }

    /** @test */
    function guests_cannot_update_posts(){
        $post = factory(Post::class)->create();

        $response = $this->put('admin/posts/'.$post->id, [
            'title' => 'Updated post title'
        ]);

        $response->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
            'title' => 'Updated post title'
        ]);
    }
}
