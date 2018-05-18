<?php

namespace Bounoable\Quest;

use Bounoable\Quest\Support\HasStatusFlags;

class Quest
{
    use HasStatusFlags;

    const COMPLETED = 1 << 0;

    /**
     * The quest missions.
     *
     * @var array
     */
    private $missions = [];

    /**
     * The quest rewards.
     *
     * @var array
     */
    private $rewards = [];

    /**
     * Get the missions.
     *
     * @return Mission[]
     */
    public function getMissions(): array
    {
        return $this->missions;
    }

    /**
     * Get the reward data.
     *
     * @return Reward[]
     */
    public function getRewards(): array
    {
        return $this->rewards;
    }

    /**
     * Determine if the quest has been completed.
     */
    public function isCompleted(): bool
    {
        return $this->hasFlag(self::COMPLETED);
    }

    /**
     * Set the status of the quest to completed.
     */
    public function complete(): void
    {
        $this->addFlag(self::COMPLETED);
    }

    /**
     * Transform the quest into an array of quest data.
     */
    public function toArray(): array
    {
        return [
            'completed' => $this->isCompleted(),
            'missions' => array_map(function (Mission $mission) {
                return $mission->toArray();
            }, $this->getMissions()),
            'rewards' => array_map(function (Reward $reward) {
                return $reward->toArray();
            }, $this->getRewards())
        ];
    }
}
