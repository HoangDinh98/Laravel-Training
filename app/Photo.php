<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'user_id', 'post_id', 'comment_id', 'is_thumbnail', 'is_active', 'path'
    ];
}
