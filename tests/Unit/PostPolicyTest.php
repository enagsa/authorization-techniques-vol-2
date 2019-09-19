<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Post;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

class PostPolicyTest extends TestCase
{
	use RefreshDatabase;

    /** @test */
    function admins_can_update_posts(){
    	// Preparación
    	$admin = $this->createAdmin();
    	$this->be($admin);
    	$post = factory(Post::class)->create();

    	// Actuación
    	//$result = Gate::allows('update', $post);
    	$result = $admin->can('update', $post);
    	//$result = auth()->user()->can('update', $post);

    	// Resultado
    	$this->assertTrue($result);
    }

    /** @test */
    function authors_can_update_posts(){
    	// Preparación
    	$user = $this->createUser();
    	$this->be($user);
    	
    	$post = factory(Post::class)->create([
    		'user_id' => $user->id
    	]);

    	// Actuación
    	$result = $user->can('update', $post);

    	// Resultado
    	$this->assertTrue($result);
    }

    /** @test */
    function unathorized_users_cannot_update_posts(){
    	// Preparación
    	$user = $this->createUser();
    	$this->be($user);
    	$post = factory(Post::class)->create();

    	// Actuación
    	$result = $user->can('update', $post);

    	// Resultado
    	$this->assertFalse($result);
    }

    /** @test */
    function guests_cannot_update_posts(){
    	// Preparación
    	$post = factory(Post::class)->create();

    	// Actuación
    	$result = Gate::allows('update', $post);

    	// Resultado
    	$this->assertFalse($result);
    }

    /** @test */
    function admins_can_delete_published_posts(){
        // Preparacion
        $admin = $this->createAdmin();
        $this->be($admin);
        $post = factory(Post::class)->state('published')->create();

        // Actuación
        $result = $admin->can('delete', $post);

        // Resultado
        $this->assertTrue($result);
    }

    /** @test */
    function authors_can_delete_posts_if_it_is_not_published(){
        // Preparacion
        $user = $this->createUser();
        $this->be($user);
        $post = factory(Post::class)->state('draft')->create([
            'user_id' => $user->id
        ]);

        // Actuación
        $result = $user->can('delete', $post);

        // Resultado
        $this->assertTrue($result);
    }

    /** @test */
    function authors_cannot_delete_posts_if_it_is_published(){
        // Preparacion
        $user = $this->createUser();
        $this->be($user);
        $post = factory(Post::class)->state('published')->create([
            'user_id' => $user->id
        ]);

        // Actuación
        $result = $user->can('delete', $post);

        // Resultado
        $this->assertFalse($result);
    }

    /** @test */
    function unathorized_users_cannot_delete_posts(){
        // Preparación
        $user = $this->createUser();
        $this->be($user);
        $post = factory(Post::class)->create();

        // Actuación
        $result = $user->can('delete', $post);

        // Resultado
        $this->assertFalse($result);
    }

    /** @test */
    function guests_cannot_delete_posts(){
        // Preparación
        $post = factory(Post::class)->create();

        // Actuación
        $result = Gate::allows('delete', $post);

        // Resultado
        $this->assertFalse($result);
    }
}
