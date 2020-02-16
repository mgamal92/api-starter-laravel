<?php

namespace Barista\Helpers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

final class Model
{
    private $filesystem;

    private $modelName;

    private $modelClass;

    private $fillable;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getClassStub()
    {
        $this->modelClass = $this->filesystem->get(__DIR__.'/../../stubs/model/class.stub');
    }

    public function getFillableStub()
    {
        $this->fillable = $this->filesystem->get(__DIR__.'/../../stubs/model/fillable.stub');
    }

    public function populateNamespace()
    {
        $this->modelClass = str_replace('DummyNamespace', 'App', $this->modelClass);
    }

    public function populateName($model)
    {
        $this->modelName = Str::studly($model);
        $this->modelClass = str_replace('DummyClass', $this->modelName , $this->modelClass);
    }

    public function populateProperties($properties)
    {
        $data = array_keys($properties);

        $output = var_export($data, true);
        $output = preg_replace('/^\s+/m', '        ', $output);
        $output = preg_replace(['/^array\s\(/', "/\)$/"], ['[', '    ]'], $output);

        $output = preg_replace('/^(\s+)[^=]+=>\s+/m', '$1', $output);

        $properties = PHP_EOL. str_replace('[]', trim($output), $this->fillable);

        $this->modelClass = str_replace('// ...', $properties, $this->modelClass);
    }

    public function populateModel()
    {
        $this->filesystem->put(__DIR__.'/../../../../../app/'. $this->modelName .'.php', $this->modelClass);
    }
}
