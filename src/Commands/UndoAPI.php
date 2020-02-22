<?php

namespace Barista\Commands;

use Barista\Parser;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class UndoAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'undo:api {file=api.json : API Input File}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove generated API files';

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var Filesystem
     */
    private $filesystem;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Parser $parser, Filesystem $filesystem)
    {
        parent::__construct();

        $this->parser = $parser;
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file = $this->argument('file');

        $tree = $this->parser->getContent(__DIR__.'/../../../../../'.$file);

        $modelsToRemove = array_keys($tree['models']); 

        foreach ($modelsToRemove as $model) {
            $this->filesystem->delete(__DIR__.'/../../../../../app/'. $model.'.php');

            $this->filesystem->delete(__DIR__.'/../../../../../app/Http/Controllers'. $model.'Controller.php');

            $migrationFileToRemove = 'create_'.Str::snake(Str::pluralStudly($model)).'_table';

            foreach ($this->filesystem->files(__DIR__.'/../../../../../database/migrations/') as $migrationFile) {
                if (strpos($migrationFile, $migrationFileToRemove) !== FALSE) {
                    $this->filesystem->delete(__DIR__.'/../../../../../database/migrations/'. basename($migrationFile));   
                }
            }
            
        }
    }
}
