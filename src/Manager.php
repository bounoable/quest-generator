<?php

namespace Bounoable\Quest;

use Exception;
use Bounoable\Quest\Export\FileExporter;
use Bounoable\Quest\Export\ExportException;
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
     * The quest exporter.
     *
     * @var FileExporter
     */
    private $exporter;

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
     * @var QuestIntegrator|null
     */
    private $integrator;

    /**
     * Initialize the quest manager.
     */
    public function __construct(Generator $generator, FileExporter $exporter, MissionTypeManager $missionTypes, RewardTypeManager $rewardTypes, ?QuestIntegrator $integrator = null)
    {
        $this->generator = $generator;
        $this->exporter = $exporter;
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
     * Get the quest exporter.
     */
    public function getExporter(): FileExporter
    {
        return $this->exporter;
    }

    /**
     * Get the mission type manager.
     */
    public function getMissionTypeManager(): MissionTypeManager
    {
        return $this->missionTypes;
    }

    /**
     * Get the reward type manager.
     */
    public function getRewardTypeManager(): RewardTypeManager
    {
        return $this->rewardTypes;
    }

    /**
     * Get the quest integrator.
     */
    public function getIntegrator(): ?QuestIntegrator
    {
        return $this->integrator;
    }

    /**
     * Set the quest integrator instance.
     */
    public function setIntegrator(?QuestIntegrator $integrator = null): void
    {
        $this->integrator = $integrator;
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
     * Export a quest to a given path.
     *
     * @throws ExportException
     */
    public function export(Quest $quest, string $path): void
    {
        $this->exporter->export($quest, $path);
    }

    /**
     * Import a quest from a file.
     *
     * @throws ImportException
     */
    public function import(string $path): Quest
    {
        return $this->exporter->import($path);
    }

    /**
     * Start a generated quest and return the created quest entity.
     */
    public function start(GeneratedQuest $quest): Quest
    {
        if ($this->integrator) {
            return $this->integrator->start($quest);
        }
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

        if ($this->integrator) {
            $this->integrator->complete($quest);
        }
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
        return $this->missionTypes
            ->resolve($mission->getType())
            ->describe($mission);
    }

    /**
     * Describe a reward.
     */
    public function describeReward(Reward $reward): string
    {
        return $this->rewardTypes
            ->resolve($reward->getType())
            ->describe($reward);
    }
}
