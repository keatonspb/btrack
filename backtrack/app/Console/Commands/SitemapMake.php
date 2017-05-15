<?php

namespace App\Console\Commands;

use App\Song;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class SitemapMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make sitemap';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo config('app.url');
        $sitemap = App::make("sitemap");
        $songs = Song::orderBy("created_at", "desc")->get();
        foreach ($songs as $song) {
            $sitemap->add("http://btrack.xyz".$song->getHref(), $song->created_at, "0.5", "monthly");
        }
        $sitemap->store('xml', 'sitemap');
    }
}
