<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * @package App
 */
class Blog extends Model
{
    /**
     * @var string
     */
    protected $table = 'blog';

    /**
     * @var array
     */
    protected $dates = ['published_at', 'deleted_at'];

    /**
     * @var string
     */
    protected $fillable = ['user_id', 'name', 'slug', 'excerpt', 'content', 'status', 'published_at'];

    /**
     * @param $slug
     */
    public static function findByTitle($slug = null)
    {
        return self::where('slug', $slug)->first();
    }
}
