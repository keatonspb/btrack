<?php

namespace App\Console\Commands\Grabbers;

use App\Author;
use App\Song;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

abstract class BaseGrabber extends Command
{



    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grabber';
    protected $base_url = "https://www.guitarbackingtrack.com";
    protected $proxy_list = [
        '152.160.35.171:80',
        '96.239.193.244:8080',
        '213.136.89.121:80'
        ];

    protected static $base_headers = [
        'User-Agent' => "Mozilla/5.0 (Windows NT 10.0; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0",
        "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8"
    ];

    public function getClient() {
        return new Client([
            'base_uri' => $this->base_url,
            'headers' => self::$base_headers,
        ]);
    }

    public function getProxy() {
        $proxy = $this->proxy_list[random_int(0, sizeof($this->proxy_list)-1)];
        echo $proxy."\n";
        return $proxy;
    }


}
