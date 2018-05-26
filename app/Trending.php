<?php

namespace App;

use App\Blog;
use Illuminate\Database\Eloquent\Model;
use Spatie\Analytics\Period;

/**
 * Class Trending
 * @package App
 */
class Trending extends Model
{
    /**
     * @var string
     */
    protected $table = 'trendings';

    /**
     * @var boolean
     */
    public $timestamps = true;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string
     */
    protected $fillable = ['blog_id', 'views', 'url', 'page_title'];

    /**
     * @return mixed
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeMonthly($query)
    {
        $period = Period::months(1);

        return $query->whereBetween('created_at', [
            $period->startDate,
            $period->endDate->endOfDay(),
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWeekly($query)
    {
        $period = Period::days(7);

        return $query->whereBetween('created_at', [
            $period->startDate,
            $period->endDate->endOfDay(),
        ]);
    }
}
