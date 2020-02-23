<?php

namespace Barista\Facades;

use Barista\Helpers\Controller;
use Illuminate\Filesystem\Filesystem;

final class ControllerFacade
{
    private $controllerHelper;

    public function __construct()
    {
        $this->controllerHelper = new Controller(new Filesystem);
    }

    public function populate($model)
    {
        dd('generating controller');
    }
}
