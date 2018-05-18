<?php

namespace Bounoable\Quest;

use Exception;

abstract class AbstractMissionType implements MissionType
{
    /**
     * Get the mission type name.
     */
    public function getType(): string
    {
        if (!defined('static::TYPE')) {
            $class = static::class;
            throw new Exception("{$class}::TYPE is not defined.");
        }

        return static::TYPE;
    }

    /**
     * Get the description of a mission.
     */
    public function describe(Mission $mission): string
    {
        if ($mission->getType() !== $this->getType()) {
            throw new Exception("Mission must be of type '{$this->getType()}'");
        }

        return $this->getDescription($mission);
    }

    /**
     * Get the description of a mission.
     */
    abstract protected function getDescription(Mission $mission): string;
}
