<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;

    public function viewAny(){
        return true;
    }

    public function update(User $user, Post $post){
        if($user->isAn('editor'))
            return Response::allow('Puedes editar este post porque eres un editor');

        if($user->isAn('author')){
            if($user->owns($post))
                return Response::allow('Eres el autor del post');

            return Response::deny('No puedes editar este post porque no eres su autor');
        }

        return Response::deny('No dispones de permisos para editar ningún post');
    }

    public function delete(User $user, Post $post){
        if($user->can('delete-published', $post))
            return true;

        return $post->isDraft() && $user->can('delete-draft', $post);
    }
}
