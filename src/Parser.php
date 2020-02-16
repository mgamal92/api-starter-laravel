<?php

namespace Barista;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;

final class Parser
{
    /**
     * @var Filesystem
     */
    private $fileSystem;

    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function getContent($fileName)
    {
        list($content, $extension) =  $this->getFileDetails($fileName);

        if (in_array($extension, config('barista.api_file_formats'))) {
            
            return Formatter::output($content, $extension);

        } else {
            throw new ExtensionFileException;
        }
    }

    public function getFileDetails($fileName)
    {
        $extension = $this->fileSystem->extension($fileName);
        $content = $this->fileSystem->get($fileName);

        return [$content, $extension];
    }

}
