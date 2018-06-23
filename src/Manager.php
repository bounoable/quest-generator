<?php

namespace Bounoable\Quest;

use Exception;
use Bounoable\Quest\Integration\QuestIntegrator;

class Manager
{
    /**
     * The quest generator.
     *
     * @var Generator
     */
    private $generator;

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
     * The quest integrator.
     *
     * @var QuestIntegrator
     */
    private $integrator;

    /**
     * Initialize the quest manager.
     */
    public function __construct(Generator $generator, MissionTypeManager $missionTypes, RewardTypeManager $rewardTypes, QuestIntegrator $integrator)
    {
        $this->generator = $generator;
        $this->missionTypes = $missionTypes;
        $this->rewardTypes = $rewardTypes;
        $this->integrator = $integrator;
    }

    /**
     * Get the quest generator.
     */
    public function getGenerator(): Generator
    {
        return $this->generator;
    }

    /**
     * Register a mission type.
     *
     * @param  \Closure|MissionType
     * @return void
     */
    public function registerMissionType(string $name, $resolver): void
    {
        $this->missionTypes->register($name, $resolver);
    }

    /**
     * Register a mission type.
     *
     * @param  \Closure|RewardType
     * @return void
     */
    public function registerRewardType(string $name, $resolver): void
    {
        $this->rewardTypes->register($name, $resolver);
    }

    /**
     * Generate quests.
     */
    public function generate(int $count = 1): array
    {
        return $this->generator->generate($count);
    }

    /**
     * Start a generated quest and return the created quest entity.
     */
    public function start(GeneratedQuest $quest): Quest
    {
        return $this->integrator->start($quest);
    }

    /**
     * Determine if all missions of a quest have been completed.
     */
    public function check(Quest $quest): bool
    {
        /** @var Mission $mission */
        foreach ($quest->getMissions() as $mission) {
            $type = $this->missionTypes->resolve($mission->getType());

            if (!$type->check($mission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Complete a quest and apply the rewards.
     */
    public function complete(Quest $quest): void
    {
        $this->applyRewards($quest);
        $this->integrator->complete($quest);
    }

    /**
     * Apply the rewards of a quest.
     */
    protected function applyRewards(Quest $quest): void
    {
        /** @var Reward $reward */
        foreach ($quest->getRewards() as $reward) {
            $type = $this->rewardTypes->resolve($reward->getType());
            $type->apply($reward);
        }
    }

    /**
     * Describe a mission or reward.
     *
     * @param  Mission|Reward  $missionOrReward
     * @return string
     */
    public function describe($missionOrReward): string
    {
        if ($missionOrReward instanceof Mission) {
            return $this->describeMission($missionOrReward);
        }

        if ($missionOrReward instanceof Reward) {
            return $this->describeReward($missionOrReward);
        }

        throw new Exception('Object must be of type ' . Mission::class . ' or ' . Reward::class . '.');
    }

    /**
     * Describe a mission.
     */
    public function describeMission(Mission $mission): string
    {
        return $this->missionTypes->resolve($mission->getType())->describe($mission);
    }

    /**
     * Describe a reward.
     */
    public function describeReward(Reward $reward): string
    {
        return $this->rewardTypes->resolve($reward->getType())->describe($reward);
    }
}
