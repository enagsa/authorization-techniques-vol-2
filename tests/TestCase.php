<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        TestResponse::macro('viewData', function($key){
            $this->ensureResponseHasView();

            $this->assertViewHas($key);

            return $this->original->$key;
        });

        TestResponse::macro('assertViewCollection', function($var){
            return new TestCollectionData($this->viewData($var));
        });

        $this->seed('BouncerSeeder');
    }

    protected function createAdmin(){
    	$user = factory(User::class)->create();
        $user->assign('admin');
        return $user;
    }

    protected function createUser(array $attributes = []){
    	return factory(User::class)->create($attributes);
    }

    protected function assertDatabaseEmpty($table, $connection = null){
    	$total = $this->getConnection($connection)->table($table)->count();

    	$this->assertSame(
    		0,
    		$total,
    		sprintf("Failed asserting the table [%s] is empty. %s %s found.", $table, $total, Str::plural('row',$total))
    	);
    }
}
