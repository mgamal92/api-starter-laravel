<?php

namespace Barista\Facades;

use Barista\Helpers\Route;
use Illuminate\Filesystem\Filesystem;

final class RouteFacade
{
    private $routeHelper;

    public function __construct()
    {
        $this->routeHelper = new Route(new Filesystem);
    }

    public function populate($model)
    {
        $this->routeHelper->populateRoutes($model);

        $this->routeHelper->writeModelInFile();
    }
}