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

    private $method;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getClassStub()
    {
        $this->modelClass = $this->filesystem->get(__DIR__.'/../../stubs/model/class.stub');
    }

    public function populateFillable()
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
        $this->modelClass = str_replace('DummyClass', $this->modelName, $this->modelClass);
    }

    public function populateProperties($properties)
    {
        $data = array_keys($properties);

        $output = var_export($data, true);
        $output = preg_replace('/^\s+/m', '        ', $output);
        $output = preg_replace(['/^array\s\(/', "/\)$/"], ['[', '    ]'], $output);

        $output = preg_replace('/^(\s+)[^=]+=>\s+/m', '$1', $output);

        $properties = PHP_EOL. str_replace('[]', trim($output), $this->fillable);

        $this->modelClass = str_replace('// properties', trim($properties), $this->modelClass);
    }

    public function populateRelation($properties)
    {
        $methods = null;

        $columns = array_keys($properties);

        $foreignKeys = array_filter($columns, function ($column) {
            return strpos($column, '_id');
        });


        if (!empty($foreignKeys)) {
            foreach($foreignKeys as $foreignKey) {
                $this->method = $this->filesystem->get(__DIR__.'/../../stubs/model/method.stub');
    
                $relationName = Str::beforeLast($foreignKey, '_id');
    
                $relationClass = Str::studly($relationName);
    
                $relationStatement  = sprintf("\$this->belongsTo(%s::class)",  $relationClass);
    
                $this->method = str_replace('null', $relationStatement , $this->method);

                $this->method =  str_replace('DummyName', $relationName , $this->method) . PHP_EOL;

                $methods .= PHP_EOL. $this->method;
            }
        }
        
        $this->modelClass = str_replace('// methods',  trim($methods), $this->modelClass);
    }

    public function populateModel()
    {
        $this->filesystem->put(__DIR__.'/../../../../../app/'. $this->modelName .'.php', $this->modelClass);
    }
}
