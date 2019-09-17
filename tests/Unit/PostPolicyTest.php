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
    	//$result = Gate::allows('update-post', $post);
    	$result = $admin->can('update-post', $post);
    	//$result = auth()->user()->can('update-post', $post);

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
    	$result = $user->can('update-post', $post);

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
    	$result = $user->can('update-post', $post);

    	// Resultado
    	$this->assertFalse($result);
    }

    /** @test */
    function guests_cannot_update_posts(){
    	// Preparación
    	$post = factory(Post::class)->create();

    	// Actuación
    	$result = Gate::allows('update-post', $post);

    	// Resultado
    	$this->assertFalse($result);
    }
}
