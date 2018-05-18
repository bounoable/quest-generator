<?php

namespace Bounoable\Quest;

interface RewardType
{
    /**
     * Describe a reward.
     */
    public function describe(Reward $reward): string;
}
