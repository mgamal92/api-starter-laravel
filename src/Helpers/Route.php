<?php

namespace Barista\Helpers;

use Barista\Contracts\Writable;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

final class Route implements Writable
{
    private const ROUTES_PATH = '/routes/api.php';

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->routes = $this->filesystem->get(base_path().self::ROUTES_PATH);
    }

    public function populateRoutes($model)
    {
        $this->routes .= PHP_EOL.PHP_EOL;

        $slug = Str::kebab(Str::plural($model));
        $controller = Str::studly($model).'Controller';

        $this->routes .= '// ';
        $this->routes .= $slug .' endpoints';
        $this->routes .= PHP_EOL;

        $this->routes .= sprintf("Route::resource('%s', '%s');", $slug, $controller);
    }

    public function write()
    {
        $this->filesystem->put(base_path().self::ROUTES_PATH, $this->routes);
    }
}