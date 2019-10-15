<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = factory(User::class)->create([
            'email' => 'admin@styde.net',
            'name' => 'Administrator'
        ]);
        $admin->assign('admin');

        $user = factory(User::class)->create([
            'email' => 'author@styde.net',
            'name' => 'Author'
        ]);
        $user->assign('author');
    }
}
