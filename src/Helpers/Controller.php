<?php

namespace Barista\Helpers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Barista\Contracts\Writable;

final class controller implements Writable
{
    const STUB_PATH = __DIR__.'/../../stubs/controller/';

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        // init stubs
        $this->controllerClass = $this->filesystem->get(self::STUB_PATH.'class.stub');
    }

    public function populateNamespace()
    {
        $this->controllerClass = str_replace('DummyNamespace', 'App\Http\Controllers', $this->controllerClass);
    }

    public function populateName($model)
    {
        $this->controllerName = Str::studly($model).'Controller';
        $this->controllerClass = str_replace('DummyClass', $this->controllerName, $this->controllerClass);
    }

    public function write()
    {
        $this->filesystem->put(app_path().'/Http/Controllers/'.$this->controllerName .'.php', $this->controllerClass);
    }
}
