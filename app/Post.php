<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

    use FullTextSearch;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'body'
    ];

    /**
     * The columns of the full text index
     */
    protected $searchable = [
        'title',
        'body',
    ];

    public function photos() {
        return $this->hasMany('App\Photo');
    }

    public function photo_thumbnail() {
//        return $this->hasMany('App\Photo')->wherePivot('is_thumbnail', 1);
//        $instance->where([['post_id', '=', $post_id],['is_thumbnail', '=', 1]]);
//        return $instance;
        return $this->photos()->where('is_thumbnail','=', 1)->first();
    }

}
