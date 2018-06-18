<?php

namespace Bounoable\Quest;

interface Quest
{
    /**
     * Get the quest missions.
     *
     * @return Mission[]
     */
    public function getMissions(): array;

    /**
     * Get the quest rewards.
     *
     * @return Reward[]
     */
    public function getRewards(): array;
}
