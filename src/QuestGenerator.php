<?php

namespace Bounoable\Quest;

use Exception;

class QuestGenerator
{
    /**
     * The mission type manager.
     *
     * @var MissionTypeManager
     */
    private $missionTypeManager;

    /**
     * Initialize the quest generator.
     */
    public function __construct(MissionTypeManager $missionTypeManager)
    {
        $this->missionTypeManager = $missionTypeManager;
    }

    public function generate(): GeneratedQuest
    {
        return new GeneratedQuest($this->generateMissions(3));
    }

    protected function generateMissions(int $count): array
    {
        $missions = [];

        while ($count--) {
            $missions[] = $this->generateMission();
        }

        return $missions;
    }

    protected function generateMission(): Mission
    {
        return $this->randomMissionType()->generate();
    }

    protected function randomMissionType(): MissionType
    {
        $typeNames = $this->missionTypeManager->getTypeNames();

        if (!count($typeNames)) {
            throw new Exception('No mission type has been registered.');
        }

        return $this->missionTypeManager->resolve($typeNames[array_rand($typeNames)]);
    }
}
