<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'body', 'slug'
    ];
    
    public function photos()
    {
        return $this->hasMany('App\Photo');
    }
}
