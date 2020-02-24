<?php

namespace Barista\Helpers;

use Illuminate\Filesystem\Filesystem;
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

    public function populateName($name)
    {
        $this->controllerName = $name;
        $this->controllerClass = str_replace('DummyClass', $this->controllerName, $this->controllerClass);
    }

    public function populateMethods($methodsNames)
    {
        $this->controllerClass = $this->setMethods($methodsNames);
    }

    public function setMethods($methodsNames)
    {
        $methods = null;

        $this->controllerClass = $this->setImports();

        foreach ($methodsNames as $methodName => $body) {
            $methods .= $this->addMethod($methodName, $body);
        }

        return str_replace('// methods', trim($methods), $this->controllerClass);
    }

    public function setImports()
    {
        $imports = null;
        $imports .= "use Illuminate\Http\Request;".PHP_EOL;
        $imports .= "use App\\".$this->model().";";

        return str_replace('// imports', trim($imports), $this->controllerClass);
    }

    public function addMethod($methodName, $body)
    {
        $methodStub = $this->filesystem->get(self::STUB_PATH.'method.stub');

        $methods = PHP_EOL . str_replace("DummyMethod", $methodName, $methodStub). PHP_EOL;

        $methodBody = "return ". $this->model()."::".$body['query']."();";

        $methods = str_replace('//', $methodBody, $methods);

        return $methods;
    }

    public function model()
    {
        return str_replace("Controller", "", $this->controllerName);
    }

    public function write()
    {
        $this->filesystem->put(app_path().'/Http/Controllers/'.$this->controllerName .'.php', $this->controllerClass);
    }
}
