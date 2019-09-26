<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $fillable = ['title'];

    public function isPublished(){
    	return $this->status === 'published';
    }

    public function author(){
    	return $this->belongsTo(User::class, 'user_id');
    }
}
