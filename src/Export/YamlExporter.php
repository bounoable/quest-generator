<?php

namespace Bounoable\Quest\Export;

use Exception;
use Bounoable\Quest\Quest;
use Bounoable\Quest\Reward;
use Bounoable\Quest\Mission;
use Symfony\Component\Yaml\Yaml;
use Bounoable\Quest\GeneratedQuest;
use Bounoable\Quest\GeneratedReward;
use Bounoable\Quest\GeneratedMission;
use Bounoable\Quest\RewardTypeManager;
use Bounoable\Quest\MissionTypeManager;
use Symfony\Component\Yaml\Exception\ParseException;

class YamlExporter implements FileExporter
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
     * Initialize the YAML exporter.
     */
    public function __construct(MissionTypeManager $missionTypes, RewardTypeManager $rewardTypes)
    {
        $this->missionTypes = $missionTypes;
        $this->rewardTypes = $rewardTypes;
    }

    /**
     * Export a quest to a given path.
     *
     * @throws ExportException
     */
    public function export(Quest $quest, string $path): void
    {
        $contents = Yaml::dump([
            'missions' => array_map(function (Mission $mission) {
                return [
                    'type' => $mission->getType(),
                    'data' => $mission->getData(),
                ];
            }, $quest->getMissions()),

            'rewards' => array_map(function (Reward $reward) {
                return [
                    'type' => $reward->getType(),
                    'data' => $reward->getData(),
                ];
            }, $quest->getRewards())
        ]);

        file_put_contents($path, $contents);

        try {
            $quest = $this->import($path);
        } catch (ImportException $e) {
            throw new ExportException('Export failed.');
        }
    }

    /**
     * Import a quest from a YAML file.
     *
     * @throws ImportException
     */
    public function import(string $path): Quest
    {
        if (!file_exists($path)) {
            throw new ImportException("File '{$path}' does not exist.");
        }

        if (!is_readable($path)) {
            throw new ImportException("File '{$path}' is not readable.");
        }

        try {
            $data = Yaml::parseFile($path);
        } catch (ParseException $e) {
            throw new ImportException($e->getMessage());
        }

        if ($this->validateData($data)) {
            throw new ImportException("File '{$path}' does not contain valid quest data.");
        }

        return $this->createFromData($data);
    }

    /**
     * Validate quest data.
     */
    protected function validateData(array $data): bool
    {
        $missions = $data['missions'] ?? [];
        $rewards = $data['rewards'] ?? [];

        foreach ($missions as $mission) {
            if (!$this->validateMissionData($mission)) {
                return false;
            }
        }

        foreach ($rewards as $reward) {
            if (!$this->validateRewardData($reward)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate mission data.
     */
    protected function validateMissionData(array $data): bool
    {
        if (!isset($data['type'])) {
            return false;
        }

        try {
            $type = $this->missionTypes->resolve($data['type']);
        } catch (Exception $e) {
            return false;
        }

        return $type->validateData($data);
    }

    /**
     * Validate reward data.
     */
    protected function validateRewardData(array $data): bool
    {
        if (!isset($data['type'])) {
            return false;
        }

        try {
            $type = $this->rewardTypes->resolve($data['type']);
        } catch (Exception $e) {
            return false;
        }

        return $type->validateData($data);
    }

    /**
     * Recreate a generated quest from quest data.
     */
    protected function createFromData(array $data): Quest
    {
        $missions = [];
        $rewards = [];

        foreach ($data['missions'] ?? [] as $missionData) {
            $missions[] = new GeneratedMission($missionData['type'], $missionData['data']);
        }

        foreach ($data['rewards'] ?? [] as $rewardData) {
            $rewards[] = new GeneratedReward($rewardData['type'], $rewardData['data']);
        }

        return new GeneratedQuest($missions, $rewards);
    }
}
