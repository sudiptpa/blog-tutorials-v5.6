<?php

namespace App\Console\Commands;

use App\Blog;
use App\Trending;
use Illuminate\Console\Command;
use Spatie\Analytics\AnalyticsFacade as Analytics;
use Spatie\Analytics\Period;

/**
 * Class TrendingCommand
 * @package App\Console\Commands
 */
class TrendingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analytics:trending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync page view from Google Analytics API';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pages = Analytics::fetchMostVisitedPages(Period::days(1), 300);

        if ($pages->count()) {
            $this->purge();

            $pages->map(function ($each) {
                $each = (object) $each;

                if (starts_with($each->url, '/blog/')) {
                    $slug = str_replace("/blog/", '', $each->url);
                    $blog = Blog::findByTitle($slug);

                    if (sizeof($blog)) {
                        Trending::create([
                            'blog_id' => $blog->id,
                            'views' => $each->pageViews,
                            'status' => $blog->status,
                            'page_title' => $blog->name,
                            'url' => $each->url,
                        ]);

                        $this->info("{$blog->name} - {$each->pageViews} \n");
                    }
                }
            });
        }
    }

    /**
     * @return mixed
     */
    public function purge()
    {
        $period = Period::days(8);

        return Trending::where('created_at', '<', $period->startDate)
            ->forceDelete();
    }
}
