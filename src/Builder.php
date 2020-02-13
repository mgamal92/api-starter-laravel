<?php

namespace Barista;

final class Builder
{
    public function __construct()
    {
        echo "preparing...";
    }

    public function generateModels()
    {
        echo "generating models...";
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
