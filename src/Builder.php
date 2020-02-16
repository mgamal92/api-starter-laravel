<?php

namespace Barista;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

final class Builder
{
    private $tree;

    private $filesystem;

    public function __construct(Filesystem $filesystem )
    {
        $this->filesystem = $filesystem;
    }

    public function prepare($tree)
    {
        $this->tree = $tree;
    }

    public function generateModels()
    {
        $models = $this->tree['models'];

        foreach ($models as $model => $properties) {

            $modelClass = $this->filesystem->get(__DIR__.'/../stubs/model/class.stub');

            // model namespace
            $modelClass = str_replace('DummyNamespace', 'App', $modelClass);

            // model name
            $modelClass = str_replace('DummyClass', Str::studly($model) , $modelClass);


            $fillable = $this->filesystem->get(__DIR__.'/../stubs/model/fillable.stub');

            $data = array_keys($properties);

            $output = var_export($data, true);
            $output = preg_replace('/^\s+/m', '        ', $output);
            $output = preg_replace(['/^array\s\(/', "/\)$/"], ['[', '    ]'], $output);

            $output = preg_replace('/^(\s+)[^=]+=>\s+/m', '$1', $output);

            $properties = PHP_EOL. str_replace('[]', trim($output), $fillable);

            $modelClass = str_replace('// ...', $properties, $modelClass);


            $this->filesystem->put(__DIR__.'/../../../../app/'. Str::studly($model) .'.php', $modelClass);
        }



    }
    
    public function generateControllers()
    {
        echo "generating controllers...";
    }

    public function generateRoutes()
    {
        echo "generating routes...";
    }

    public function generateMigrations()
    {
        echo "generating migrations...";
    }

    public function generateFactory()
    {
        echo "generating factory...";
    }
}
