<?php

namespace App\Http\Controllers;

use Vinkla\Instagram\Instagram;

/**
 * Class InstagramController
 * @package App\Http\Controllers
 */
class InstagramController extends Controller
{
    /**
     * @return mixed
     */
    public function feed()
    {
        $instagram = new Instagram(config('instagram.api.access-token'));

        $images = collect($instagram->get())->map(function ($each) {
            return $each->images->standard_resolution->url;
        });

        return view('feed', compact('images'));
    }
}
