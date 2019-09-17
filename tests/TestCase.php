<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createAdmin(){
    	return factory(User::class)->states('admin')->create();
    }

    protected function createUser(){
    	return factory(User::class)->create();
    }
}
