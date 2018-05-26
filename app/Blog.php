<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * @package App
 */
class Blog extends Model
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

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
    protected $fillable = ['user_id', 'name', 'slug', 'guid', 'excerpt', 'content', 'status', 'published_at'];

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now());
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeEnabled($query)
    {
        return $query->where('status', self::STATUS_ENABLED);
    }
}
