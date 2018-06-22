<?php

namespace Bounoable\Quest;

abstract class AbstractRewardType implements RewardType
{
    /**
     * Get the reward type name.
     */
    public function getTypeName(): string
    {
        if (!defined('static::NAME')) {
            throw new Exception(static::class . '::NAME is not defined.');
        }

        return static::NAME;
    }

    public function describe(Reward $reward): string
    {
        $this->validateType($reward);

        return $this->getDescription($reward);
    }

    protected function validateType(Reward $reward): void
    {
        if ($reward->getType() !== $this->getTypeName()) {
            throw new Exception("Reward must be of type '{$this->getTypeName()}'");
        }
    }

    abstract protected function getDescription(Reward $reward): string;

    abstract public function generate(): Reward;

    abstract public function apply(Reward $reward): void;

    abstract public function validateData(array $data): bool;
}
