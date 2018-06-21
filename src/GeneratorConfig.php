<?php

namespace Bounoable\Quest;

class GeneratorConfig
{
    /**
     * The minimum and maximum missions per quest.
     *
     * @var int[]
     */
    private $missionsPerQuest = [1, 3];

    /**
     * The minimum and maximum rewards per quest.
     *
     * @var int[]
     */
    private $rewardsPerQuest = [1, 3];

    /**
     * Set the minimum and maximum missions per quest.
     *
     * @param  int  $min
     * @param  int  $max
     * @return $this
     */
    public function missionsPerQuest(int $min, int $max): self
    {
        $min = $min < 1 ? 1 : $min;
        $max = $max < $min ? $min : $max;

        $this->missionsPerQuest = [$min, $max];

        return $this;
    }

    /**
     * Set the minimum and maximum rewards per quest.
     *
     * @param  int  $min
     * @param  int  $max
     * @return $this
     */
    public function rewardsPerQuest(int $min, int $max): self
    {
        $min = $min < 1 ? 1 : $min;
        $max = $max < $min ? $min : $max;

        $this->rewardsPerQuest = [$min, $max];

        return $this;
    }

    /**
     * Get the mission count range.
     *
     * @return int[]
     */
    public function getMissionsPerQuest(): array
    {
        return $this->missionsPerQuest;
    }

    /**
     * Get the reward count range.
     *
     * @return int[]
     */
    public function getRewardsPerQuest(): array
    {
        return $this->rewardsPerQuest;
    }
}
