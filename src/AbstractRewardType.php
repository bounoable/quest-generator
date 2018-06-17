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

    /**
     * Describe a reward.
     */
    public function describe(Reward $reward): string
    {
        if ($reward->getType() !== $this->getTypeName()) {
            throw new Exception("Reward must be of type '{$this->getTypeName()}'");
        }

        return $this->getDescription($reward);
    }

    /**
     * Describe a reward.
     */
    abstract protected function getDescription(Reward $reward): string;

    /**
     * Generate a reward.
     */
    abstract public function generate(): GeneratedReward;

    /**
     * Apply a reward.
     */
    abstract public function apply(Reward $reward): void;
}
