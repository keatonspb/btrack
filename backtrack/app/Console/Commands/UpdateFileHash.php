<?php

namespace App\Console\Commands;

use App\Song;
use App\Track;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class UpdateFileHash extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:updatehash';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update file hash';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tracks = Track::whereNull("hash")->get();
        foreach ($tracks as $track) {
            $track->hash = $track->getFileHash();
            $track->save();
        }
    }
}
