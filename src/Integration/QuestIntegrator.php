<?php

namespace Bounoable\Quest\Integration;

use Bounoable\Quest\Quest;
use Bounoable\Quest\GeneratedQuest;

interface QuestIntegrator
{
    /**
     * Create a quest entity from a generated quest.
     */
    public function start(GeneratedQuest $generated): Quest;

    /**
     * Handle the completion of a quest.
     */
    public function complete(Quest $quest): void;
}
