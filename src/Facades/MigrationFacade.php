<?php

namespace Barista\Facades;

use Barista\Helpers\Model;
use Illuminate\Filesystem\Filesystem;

final class MigrationFacade
{
    private $modelHelper;

    public function __construct()
    {
        $this->modelHelper = new Model(new Filesystem);
    }

    public function populate($model, $properties)
    {
        $this->modelHelper->populateNamespace();

        $this->modelHelper->populateName($model);

        $this->modelHelper->populateProperties($properties);

        $this->modelHelper->populateRelation($properties);

        $this->modelHelper->writeModelInFile();
    }
}
