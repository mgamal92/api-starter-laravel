<?php

namespace Barista\Commands;

use Barista\Builder;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class PrepareAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prepare:api {file=api.json : API Input File}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prepare your api with docs';

    /**
     * @var Builder
     */
    private $builder;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Builder $builder)
    {
        parent::__construct();

        $this->builder = $builder;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');

        echo "\n";
        
        $this->builder->generateModels();
        
        echo "\n";
        $this->builder->generateControllers();

        echo "\n";
        $this->builder->generateRoutes();

        echo "\n";
        $this->builder->generateMigrations();

        echo "\n";
        $this->builder->generateFactory();
        
        echo "\n";
        $this->info('The API endpoints has been generated sucessfully!');
    }
}
