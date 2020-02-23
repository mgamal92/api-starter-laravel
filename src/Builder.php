<?php

namespace Barista;

use Barista\Facades\ControllerFacade;
use Barista\Facades\MigrationFacade;
use Barista\Facades\ModelFacade;
use Barista\Facades\RouteFacade;

final class Builder
{
    private $tree;

    public function prepare($tree)
    {
        $this->tree = $tree;
    }

    public function generateModels()
    {
        foreach ($this->tree['models'] as $model => $properties) {
            (new ModelFacade)->populate($model, $properties);
        }
    }
    
    public function generateMigrations()
    {
        foreach ($this->tree['models'] as $model => $properties) {
            (new MigrationFacade)->populate($model, $properties);
        }
    }


    public function generateRoutes()
    {
        foreach ($this->tree['models'] as $model => $properties) {
            (new RouteFacade)->populate($model);
        }
    }

    public function generateControllers()
    {
        foreach ($this->tree['models'] as $model => $properties) {
            (new ControllerFacade)->populate($model);
        }
    }

    public function generateFactory()
    {
        echo "generating factory...";
    }
}
