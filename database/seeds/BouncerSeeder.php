<?php

use App\Models\Post;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRoles();
        $this->createAbilities();

        Bouncer::allow('admin')->everything();
        Bouncer::allow('author')->to('create', Post::class);
        Bouncer::allow('author')->toOwn(Post::class)->to(['delete-draft']);
        Bouncer::allow('editor')->to(['delete-draft'], Post::class);
    }

    protected function createRoles(){
        Bouncer::role()->create([
            'name' => 'admin',
            'title' => 'Administrador'
        ]);
        Bouncer::role()->create([
            'name' => 'editor',
            'title' => 'Editor'
        ]);
        Bouncer::role()->create([
            'name' => 'author',
            'title' => 'Autor'
        ]);
    }

    protected function createAbilities(){
        Bouncer::ability()->create([
            'name' => '*',
            'title' => 'Todas las habilidades',
            'entity_type' => '*'
        ]);
        Bouncer::ability()->createForModel(Post::class, [
            'name' => 'create',
            'title' => 'Crear publicaciones'
        ]);
        Bouncer::ability()->createForModel(Post::class, [
            'name' => 'update',
            'title' => 'Actualizar publicaciones'
        ]);
        Bouncer::ability()->createForModel(Post::class, [
            'name' => 'update',
            'title' => 'Actualizar publicaciones propias',
            'only_owned' => true
        ]);
    }
}
