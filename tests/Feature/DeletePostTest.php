<?php

namespace Tests\Feature;

use App\Models\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeletePostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function admin_can_delete_posts(){
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $post = factory(Post::class)->create();

        $this->delete("admin/posts/{$post->id}")
            ->assertRedirect('admin/posts')
            ->assertDontSee($post->title);

        $this->assertDatabaseMissing('posts',[
            'id' => $post->id
        ]);
    }

    /** @test */
    function editors_can_delete_drafts(){
        $editor = $this->createUser();
        $editor->assign('editor');

        $this->actingAs($editor);

        $post = factory(Post::class)->create([
            'status' => 'draft'
        ]);

        $this->delete("admin/posts/{$post->id}")
            ->assertRedirect('admin/posts')
            ->assertDontSee($post->title);

        $this->assertDatabaseMissing('posts',[
            'id' => $post->id
        ]);
    }

    /** @test */
    function editors_cannot_delete_published_posts(){
        $editor = $this->createUser();
        $editor->assign('editor');

        $this->actingAs($editor);

        $post = factory(Post::class)->create([
            'status' => 'published'
        ]);

        $this->delete("admin/posts/{$post->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('posts',[
            'id' => $post->id
        ]);
    }

    /** @test */
    function authors_can_delete_drafts_they_own(){
        $author = $this->createUser();
        $author->assign('author');

        $this->actingAs($author);

        $post = factory(Post::class)->create([
            'status' => 'draft',
            'user_id' => $author->id
        ]);

        $this->delete("admin/posts/{$post->id}")
            ->assertRedirect('admin/posts')
            ->assertDontSee($post->title);

        $this->assertDatabaseMissing('posts',[
            'id' => $post->id
        ]);
    }

    /** @test */
    function authors_cannot_delete_drafts_they_dont_own(){
        $post = factory(Post::class)->create([
            'status' => 'draft',
        ]);

        $author = $this->createUser();
        $author->assign('author');

        $this->actingAs($author);

        $this->delete("admin/posts/{$post->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('posts',[
            'id' => $post->id
        ]);
    }

    /** @test */
    function authors_cannot_delete_published_posts(){
        $author = $this->createUser();
        $author->assign('author');

        $post = factory(Post::class)->create([
            'status' => 'published',
            'user_id' => $author->id
        ]);

        $this->actingAs($author);

        $this->delete("admin/posts/{$post->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('posts',[
            'id' => $post->id
        ]);
    }

    /** @test */
    function unauthorized_users_cannot_delete_posts(){
        $user = $this->createUser();

        $post = factory(Post::class)->create();

        $this->actingAs($user);

        $this->delete("admin/posts/{$post->id}")
            ->assertStatus(403);

        $this->assertDatabaseHas('posts',[
            'id' => $post->id
        ]);
    }

    /** @test */
    function guests_cannot_delete_posts(){
        $post = factory(Post::class)->create();

        $this->delete("admin/posts/{$post->id}")
            ->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->assertDatabaseHas('posts',[
            'id' => $post->id
        ]);
    }
}
