<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Support\Str;

/**
 * Class BlogController
 * @package App\Http\Controllers
 */
class BlogController extends Controller
{
    public function rss()
    {
        $blogs = Blog::enabled()
            ->published()
            ->latest('published_at')
            ->get();

        $blogs->map(function ($each) {
            if (empty($each->guid)) {
                $each->guid = Str::uuid();
            }
        });

        return view('rss', [
            'blogs' => $blogs,
            'title' => 'Short title about your blog',
        ]);
    }

    /**
     * @param $slug
     */
    public function view($slug)
    {
        return Blog::where('slug', $slug)->first();
    }
}
