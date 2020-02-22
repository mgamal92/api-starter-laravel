<?php

namespace Barista;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

final class Destructor
{
    /**
     * @var Filesystem
    */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }


    public function destruct($tree)
    {
        $modelsToRemove = array_keys($tree['models']); 

        $routesFilePath = base_path().'/routes/api.php';

        $allRoutes = $this->filesystem->get($routesFilePath);


        foreach ($modelsToRemove as $model) {

            $this->deleteModel($model);

            $this->deleteController($model);

            foreach ($this->getMigrationFiles() as $migrationFile) {
                if (strpos($migrationFile, $this->getMigrationFileToRemove($model)) !== FALSE) {
                    $this->deleteMigrationFile($migrationFile);
                }
            }

            $slug = Str::kebab(Str::plural($model));
            $controller = Str::studly($model).'Controller';

            $routesComment = '// '.$slug .' endpoints';
            $routes =  sprintf("Route::resource('%s', '%s');", $slug, $controller);

            $allRoutes = str_replace($routesComment, "", $allRoutes);
            $allRoutes = str_replace($routes, "", $allRoutes);
        }

        $this->filesystem->put($routesFilePath, trim($allRoutes));
    }

    public function deleteModel($model)
    {
        $this->filesystem->delete(app_path().'/'. $model.'.php');
    }

    public function deleteController($model)
    {
        $this->filesystem->delete(app_path().'/Http/Controllers/'. $model.'Controller.php');
    }

    public function getMigrationFileToRemove($model)
    {
        return 'create_'.Str::snake(Str::pluralStudly($model)).'_table';
    }

    public function getMigrationFiles()
    {
        return $this->filesystem->files(database_path('migrations/'));
    }

    public function deleteMigrationFile($migrationFile)
    {
        $this->filesystem->delete(base_path().'/database/migrations/'. basename($migrationFile));   
    }

    public function deleteRoute($allRoutes, $model)
    {
        $slug = Str::kebab(Str::plural($model));
        $controller = Str::studly($model).'Controller';

        $routesComment = '// '.$slug .' endpoints';
        $routes =  sprintf("Route::resource('%s', '%s');", $slug, $controller);

        $allRoutes = str_replace($routesComment, "", $allRoutes);
        $allRoutes .= str_replace($routes, "", $allRoutes);


        

        

        
    }
}