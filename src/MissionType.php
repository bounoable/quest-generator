<?php

namespace Bounoable\Quest;

interface MissionType
{
    /**
     * Generate a mission.
     */
    public function generate(): GeneratedMission;

    /**
     * Describe a mission.
     */
    public function describe(Mission $mission): string;

    /**
     * Determine if a mission has been completed.
     */
    public function check(Mission $mission): bool;

    /**
     * Validate mission data.
     */
    public function validateData(array $data): bool;
}
