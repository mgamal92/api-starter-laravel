<?php

namespace Barista\Helpers;

use Illuminate\Filesystem\Filesystem;
use Barista\Contracts\Writable;

final class Controller implements Writable
{
    const STUB_PATH = __DIR__.'../../stubs/controller/';

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function write()
    {
        dd('write');
    }
}