<?php

namespace Bounoable\Quest;

class GeneratedQuest extends GeneratedObject implements Quest
{
    /**
     * The generated missions.
     *
     * @var GeneratedMission[]
     */
    private $missions = [];

    /**
     * The generated rewards.
     *
     * @var GeneratedReward[]
     */
    private $rewards = [];

    /**
     * Create a generated quest.
     */
    public function __construct(array $missions = [], array $rewards = [])
    {
        $this->addMission($missions);
        $this->addReward($rewards);
    }

    /**
     * Add a mission to the quest.
     */
    public function addMission($missions): void
    {
        $missions = is_array($missions) ? $missions : func_get_args();

        foreach ($missions as $mission) {
            if ($mission instanceof GeneratedMission) {
                $this->missions[] = $mission;
            }
        }
    }

    /**
     * Get the generated missions.
     *
     * @return GeneratedMission[]
     */
    public function getMissions(): array
    {
        return $this->missions;
    }

    /**
     * Add a reward to the quest.
     */
    public function addReward($rewards): void
    {
        $rewards = is_array($rewards) ? $rewards : func_get_args();

        foreach ($rewards as $reward) {
            if ($reward instanceof GeneratedReward) {
                $this->rewards[] = $reward;
            }
        }
    }

    /**
     * Get the generated rewards.
     *
     * @return GeneratedReward[]
     */
    public function getRewards(): array
    {
        return $this->rewards;
    }

    /**
     * Transform the generated quest into an array.
     */
    public function toArray(): array
    {
        return [
            'missions' => array_map(function (GeneratedMission $mission) {
                return $mission->toArray();
            }, $this->getMissions()),

            'rewards' => array_map(function (GeneratedReward $reward) {
                return $reward->toArray();
            }, $this->getRewards())
        ];
    }
}
