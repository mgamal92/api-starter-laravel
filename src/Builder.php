<?php

namespace Barista;

use Barista\Facades\MigrationFacade;
use Barista\Facades\ModelFacade;

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

    public function generateControllers()
    {
        echo "generating controllers...";
    }

    public function generateRoutes()
    {
        echo "generating routes...";
    }

    public function generateFactory()
    {
        echo "generating factory...";
    }
}
