<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'post_id', 'author', 'email', 'body', 'parent_id'
    ];
    
    public function comments() {
        return $this->hasMany('App\Comment', 'parent_id', 'id');
    }

    public function childComment($parent_id) {
        return $this->comments()->where('parent_id','=', $parent_id)->get();
//        return compact('childcomment');
    }
}
