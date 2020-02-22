<?php

namespace Barista\Commands;

use Barista\Destructor;
use Barista\Parser;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

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

        $tree = $this->parser->getContent(base_path().'/'.$file);

        (new Destructor($this->filesystem))->destruct($tree);

        $this->info('The Generate API files have been destructed sucessfully!');
    }
}
