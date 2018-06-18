<?php

namespace Bounoable\Quest;

class GeneratorConfig
{
    /**
     * The minimum and maximum rewards per mission.
     *
     * @var int[]
     */
    private $rewardsPerMission = [1, 3];

    /**
     * Set the minimum and maximum rewards per mission.
     *
     * @param  int  $min
     * @param  int  $max
     * @return $this
     */
    public function rewardsPerMission(int $min, int $max): self
    {
        $min = $min < 1 ? 1 : $min;
        $max = $max < $min ? $min : $max;

        $this->rewardsPerMission = [$min, $max];

        return $this;
    }

    /**
     * Get the reward count range.
     *
     * @return int[]
     */
    public function getRewardsPerMission(): array
    {
        return $this->rewardsPerMission;
    }
}
