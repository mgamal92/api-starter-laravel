<?php

namespace Barista;

final class Builder
{
    private $tree;

    public function prepare($tree)
    {
        $this->tree = $tree;
    }

    public function generateModels()
    {
        return $this->tree['models'];
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
