<?php

namespace App\Console\Commands;

use App\Image;
use Illuminate\Console\Command;

class Next extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:next';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finds the next image to show.';

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
        /** @var Image */
        $image = Image::next();
        $this->info('Next image is ' . $image->id . ': ' . $image->path);
    }
}
