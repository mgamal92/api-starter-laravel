<?php

namespace Barista;

use Symfony\Component\Yaml\Yaml;

final class Formatter
{
    public static function output($content, $extension)
    {
        switch ($extension) {
            case 'json':
                return json_decode($content, true);

            case 'yaml':
                return Yaml::parse($content);
        }     
    }
}