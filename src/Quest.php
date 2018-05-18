<?php

namespace Bounoable\Quest;

class Quest
{
    /**
     * The mission data.
     *
     * @var array
     */
    private $missionData = [];

    /**
     * The reward data.
     *
     * @var array
     */
    private $rewardData = [];

    /**
     * Get the mission data.
     */
    public function getMissionData(): array
    {
        return $this->missionData;
    }

    /**
     * Get the reward data.
     */
    public function getRewardData(): array
    {
        return $this->rewardData;
    }
}
