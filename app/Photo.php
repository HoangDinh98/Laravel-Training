<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {

    protected $fillable = [
        'user_id', 'post_id', 'comment_id', 'is_thumbnail', 'is_active', 'path'
    ];

    public function post() {
        return $this->belongsTo('App\Post');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }
    
    public function comment() {
        return $this->belongsTo('App\Comment');
    }

}
