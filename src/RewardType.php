<?php

namespace Bounoable\Quest;

interface RewardType
{
    /**
     * Generate a reward.
     */
    public function generate(): GeneratedReward;

    /**
     * Describe a reward.
     */
    public function describe(Reward $reward): string;

    /**
     * Apply a reward.
     */
    public function apply(Reward $reward): void;

    /**
     * Validate reward data.
     */
    public function validateData(array $data): bool;
}
