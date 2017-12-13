<?php

namespace App\Backend;

use Atlas\Orm\AtlasContainer;

class DbConnection
{
    private $atlas;

    public function __construct(Config $config)
    {
        $atlasContainer = new AtlasContainer(sprintf('mysql:host=%s;dbname=%s', $config->geDbHost(), $config->geDbName()),
            $config->geDbUser(),
            $config->geDbPass()
        );

        $atlasContainer->setMappers($this->mappers());
        $this->atlas = $atlasContainer->getAtlas();
    }

    private function mappers()
    {
        return [
            UsersMapper::class
        ];
    }

    public function getAtlas()
    {
        return $this->atlas;
    }
}