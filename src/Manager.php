<?php

namespace Bounoable\Quest;

use Bounoable\Quest\Integration\QuestIntegrator;

class Manager
{
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
    public function __construct(RewardTypeManager $rewardTypes, QuestIntegrator $integrator)
    {
        $this->rewardTypes = $rewardTypes;
        $this->integrator = $integrator;
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
    public function isCompleted(Quest $quest): bool
    {
        /** @var Mission $mission */
        foreach ($quest->getMissions() as $mission) {
            if (!$mission->isCompleted()) {
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
}
