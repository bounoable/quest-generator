<?php

namespace Bounoable\Quest;

interface MissionType
{
    /**
     * Generate a mission.
     */
    public function generate(): GeneratedMission;

    /**
     * Start a generated mission.
     */
    public function start(GeneratedMission $mission): void;

    /**
     * Describe a mission.
     */
    public function describe(Mission $mission): string;

    /**
     * Determine if a mission has been completed.
     */
    public function check(Mission $mission): bool;

    /**
     * Complete a mission.
     */
    public function complete(Mission $mission): void;
}
