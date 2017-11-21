<?php

namespace App\Console\Commands;

use App\Image;
use Illuminate\Console\Command;

class Scan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:scan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scanns the source directory recursively for new images.';

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
        /** @var string */
        $directory = env('SCAN_DIR');
        $this->info('Scanning ' . $directory . ' for new files.');

        /** @var integer */
        $count = Image::scan($directory);
        $this->info($count . ' new images found.');
    }
}
