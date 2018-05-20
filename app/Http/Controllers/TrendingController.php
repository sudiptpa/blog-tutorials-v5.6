<?php

namespace App\Http\Controllers;

use App\Trending;
use Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;

/**
 * Class TrendingController
 * @package App\Http\Controllers
 */
class TrendingController extends Controller
{
    /**
     * @return mixed
     */
    public function show()
    {
        $trendings = Analytics::fetchMostVisitedPages(
            Period::days(7),
            15
        );

        return view('trending', compact('trendings'));
    }
}
