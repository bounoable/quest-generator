<?php

namespace Bounoable\Quest;

use Exception;

abstract class AbstractMissionType implements MissionType
{
    /**
     * Get the mission type name.
     */
    public function getTypeName(): string
    {
        if (!defined('static::NAME')) {
            throw new Exception(static::class . '::NAME is not defined.');
        }

        return static::NAME;
    }

    /**
     * Describe a mission.
     */
    public function describe(Mission $mission): string
    {
        if ($mission->getType() !== $this->getTypeName()) {
            throw new Exception("Mission must be of type '{$this->getTypeName()}'");
        }

        return $this->getDescription($mission);
    }

    /**
     * Describe a mission.
     */
    abstract protected function getDescription(Mission $mission): string;

    /**
     * Generate a mission.
     */
    abstract public function generate(): GeneratedMission;

    /**
     * Start a generated mission.
     */
    abstract public function start(GeneratedMission $mission): Mission;

    /**
     * Determine if a mission has been completed.
     */
    abstract public function check(Mission $mission): bool;

    /**
     * Complete a mission.
     */
    abstract public function complete(Mission $mission): void;
}
