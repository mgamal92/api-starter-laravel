<?php

namespace Barista\Facades;

use Barista\Helpers\Migration;
use Illuminate\Filesystem\Filesystem;

final class MigrationFacade
{
    private $migrationHelper;

    public function __construct()
    {
        $this->migrationHelper = new Migration(new Filesystem);
    }

    public function populate($model, $properties)
    {
        $this->migrationHelper->populateName($model);

        $this->migrationHelper->populateTableName($model);

        $this->migrationHelper->populateColumns($properties);

        $this->migrationHelper->write();
    }
}
