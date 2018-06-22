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

    public function describe(Mission $mission): string
    {
        if ($mission->getType() !== $this->getTypeName()) {
            throw new Exception("Mission must be of type '{$this->getTypeName()}'");
        }

        return $this->getDescription($mission);
    }

    abstract protected function getDescription(Mission $mission): string;

    abstract public function generate(): Mission;

    abstract public function check(Mission $mission): bool;

    abstract public function validateData(array $data): bool;
}
