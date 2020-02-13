<?php

namespace Barista\Commands;

use Illuminate\Console\Command;

class PrepareAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prepare:api';

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
        dd('preparing');
    }
}
