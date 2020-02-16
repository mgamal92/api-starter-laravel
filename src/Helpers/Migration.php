<?php

namespace Barista\Helpers;

use Illuminate\Filesystem\Filesystem;

final class Migraton
{
    const STUB_PATH = __DIR__.'../../stubs/database/migrations.stub';

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }
}
