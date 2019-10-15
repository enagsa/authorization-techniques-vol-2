<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Post $post){
        if($user->can('delete-published', $post))
            return true;

        return $post->isDraft() && $user->can('delete-draft', $post);
    }
}
