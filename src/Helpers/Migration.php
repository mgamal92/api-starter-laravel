<?php

namespace Barista\Helpers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

final class Migration
{
    private const STUB_PATH = __DIR__.'/../../stubs/database/';

    private $tableName;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        // init stubs
        $this->migrationClass = $this->filesystem->get(self::STUB_PATH.'migrations.stub');
    }


    public function populateName($model)
    {
        $migrationName = 'Create'.Str::studly($model).'Table';
        $this->migrationClass = str_replace('DummyClass', $migrationName, $this->migrationClass);
    }

    public function populateTableName($model)
    {
        $this->tableName = Str::snake(Str::pluralStudly($model));

        $this->migrationClass = str_replace('DummyTable', $this->tableName, $this->migrationClass);
    }

    public function populateColumns($properties)
    {
        $definations = null;

        foreach ($properties as $column => $details) {
            foreach ($details as $key => $detail) {
                if ($key == 'type') {
                    $definations .= "            ". sprintf("\$table->%s(\"%s\");", $detail, $column);
                    $definations .= PHP_EOL;
                }
            }
        }

        $this->migrationClass = str_replace('// definition...', trim($definations) , $this->migrationClass);
    }

    public function writeMigrationInFile()
    {
        $fileName = date('Y_m_d_His') . '_create_' . $this->tableName . '_table.php';

        $this->filesystem->put(__DIR__.'/../../../../../database/migrations/'. $fileName .'.php', $this->migrationClass);
    }
}
