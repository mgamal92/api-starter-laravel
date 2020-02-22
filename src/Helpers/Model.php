<?php

namespace Barista\Helpers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Barista\Contracts\Writable;

final class Model implements Writable
{
    const STUB_PATH = __DIR__.'/../../stubs/model/';

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        // init stubs
        $this->modelClass = $this->filesystem->get(self::STUB_PATH.'class.stub');
        $this->fillable = $this->filesystem->get(self::STUB_PATH.'fillable.stub');
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
        $output = $this->formatPropertiesArray($properties);
        
        $properties = PHP_EOL. str_replace('[]', trim($output), $this->fillable);

        $this->modelClass = str_replace('// properties', trim($properties), $this->modelClass);
    }

    public function formatPropertiesArray($properties)
    {
        // properties name
        $data = array_keys($properties);

        // convert array to string
        $output = var_export($data, true);
    
        // make indentation
        $output = preg_replace('/^\s+/m', '        ', $output);

        // remove array keywork and replace it with square brackets
        $output = preg_replace(['/^array\s\(/', "/\)$/"], ['[', '    ]'], $output);

        // remove array index
        $output = preg_replace('/^(\s+)[^=]+=>\s+/m', '$1', $output);

        return $output;
    }

    public function populateRelation($properties)
    {
        $methods = null;

        $foreignKeys = $this->getForeignKeys($properties);

        foreach($foreignKeys as $foreignKey) {
            $this->method = $this->filesystem->get(self::STUB_PATH.'method.stub');

            $methods .= $this->buildRelationMethod($foreignKey);
        }
        
        $this->modelClass = str_replace('// methods',  trim($methods), $this->modelClass);
    }

    public function getForeignKeys($properties)
    {
        $columns = array_keys($properties);

        return array_filter($columns, function ($column) {
            return strpos($column, '_id');
        });
    }

    public function buildRelationMethod($foreignKey)
    {
        // remove _id from string
        $relationName = Str::beforeLast($foreignKey, '_id');

        // generate relation class name
        $relationClass = Str::studly($relationName);

        // generate relation statement
        $relationStatement  = sprintf("\$this->belongsTo(%s::class)",  $relationClass);

        $this->method = str_replace('null', $relationStatement , $this->method);
        $this->method =  str_replace('DummyName', $relationName , $this->method) . PHP_EOL;

        return PHP_EOL. $this->method;
    }

    public function write()
    {
        $this->filesystem->put(__DIR__.'/../../../../../app/'. $this->modelName .'.php', $this->modelClass);
    }
}
