<?php

namespace Bounoable\Quest;

interface MissionType
{
    /**
     * Describe a mission.
     */
    public function describe(Mission $mission): string;
}
