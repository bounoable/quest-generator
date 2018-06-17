<?php

namespace Bounoable\Quest;

class MissionTypeManager extends TypeManager
{
    /**
     * Resolve a mission type.
     */
    public function resolve(string $name): MissionType
    {
        return parent::resolve($name);
    }
}
