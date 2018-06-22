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
        $this->validateType($mission);

        return $this->getDescription($mission);
    }

    protected function validateType(Mission $mission): void
    {
        if ($mission->getType() !== $this->getTypeName()) {
            throw new Exception("Mission must be of type '{$this->getTypeName()}'");
        }
    }

    abstract protected function getDescription(Mission $mission): string;

    abstract public function generate(): Mission;

    public function check(Mission $mission): bool
    {
        $this->validateType($mission);

        return $this->isCompleted($mission);
    }

    abstract protected function isCompleted(Mission $mission): bool;

    abstract public function validateData(array $data): bool;
}
