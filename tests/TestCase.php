<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createAdmin(){
    	return factory(User::class)->states('admin')->create();
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
