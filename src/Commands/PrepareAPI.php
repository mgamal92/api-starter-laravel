<?php

namespace Barista\Commands;

use Barista\FileHandler\FileProcessor;
use Barista\FileHandler\JsonFormat;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use PHPUnit\Util\Json;

class PrepareAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prepare:api {file=api.json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare your api with docs';

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
        $file = $this->argument('file');

        dd($file);
    }
}
