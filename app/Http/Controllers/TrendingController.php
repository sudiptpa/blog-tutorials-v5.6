<?php

namespace App\Http\Controllers;

use App\Helpers\Trending;

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
        $trendings = Trending::weekly();

        return view('trending', compact('trendings'));
    }
}
