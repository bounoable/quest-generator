<?php

namespace Bounoable\Quest;

use Exception;

class Generator
{
    /**
     * The mission type manager.
     *
     * @var MissionTypeManager
     */
    private $missionTypes;

    /**
     * The reward type manager.
     *
     * @var RewardTypeManager
     */
    private $rewardTypes;

    /**
     * The generator configuration.
     *
     * @var GeneratorConfig
     */
    private $config;

    /**
     * Initialize the quest generator.
     */
    public function __construct(MissionTypeManager $missionTypes, RewardTypeManager $rewardTypes, ?GeneratorConfig $config = null)
    {
        $this->missionTypes = $missionTypes;
        $this->rewardTypes = $rewardTypes;
        $this->config = $config ?: new GeneratorConfig;
    }

    /**
     * Initialize the quest generator.
     */
    public static function make(): self
    {
        return new static(new MissionTypeManager, new RewardTypeManager);
    }

    /**
     * Get the configuration.
     */
    public function configure(): GeneratorConfig
    {
        return $this->config;
    }

    /**
     * Generate quests.
     *
     * @return GeneratedQuest[]
     */
    public function generate(int $count = 1): array
    {
        while ($count--) {
            $missionCount = mt_rand(...$this->config->getMissionsPerQuest());
            $rewardCount = mt_rand(...$this->config->getRewardsPerQuest());

            $quests[] = new GeneratedQuest(
                $this->generateMissions($missionCount),
                $this->generateRewards($rewardCount)
            );
        }

        return $quests ?? [];
    }

    /**
     * Generate missions for a quest.
     *
     * @param  int  $count
     * @return GeneratedMission[]
     */
    protected function generateMissions(int $count): array
    {
        $missions = [];

        while ($count--) {
            $missions[] = $this->generateMission();
        }

        return $missions;
    }

    /**
     * Generate a mission.
     */
    protected function generateMission(): Mission
    {
        return $this->randomMissionType()->generate();
    }

    /**
     * Get a random mission type.
     */
    protected function randomMissionType(): MissionType
    {
        return $this->getRandomType($this->missionTypes);
    }

    /**
     * Get a random type of a type manager.
     *
     * @param  TypeManager  $typeManager
     * @return mixed
     */
    protected function getRandomType(TypeManager $typeManager)
    {
        $typeNames = $typeManager->getTypeNames();

        if (!count($typeNames)) {
            throw new Exception('No type has been registered in type manager ' . get_class($typeManager) . '.');
        }

        return $typeManager->resolve($typeNames[array_rand($typeNames)]);
    }

    /**
     * Generate rewards for a quest.
     *
     * @param  int  $count
     * @return GeneratedReward[]
     */
    protected function generateRewards(int $count): array
    {
        $rewards = [];

        while ($count--) {
            $rewards[] = $this->generateReward();
        }

        return $rewards;
    }

    /**
     * Generate a reward.
     */
    protected function generateReward(): GeneratedReward
    {
        return $this->randomRewardType()->generate();
    }

    /**
     * Get a random reward type.
     */
    protected function randomRewardType(): RewardType
    {
        return $this->getRandomType($this->rewardTypes);
    }
}
