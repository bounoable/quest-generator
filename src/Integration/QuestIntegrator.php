<?php

namespace Bounoable\Quest\Integration;

use Bounoable\Quest\Quest;

interface QuestIntegrator
{
    /**
     * Start a quest and return the instance of the started quest.
     */
    public function start(Quest $quest): Quest;

    /**
     * Handle the completion of a quest.
     */
    public function complete(Quest $quest): void;
}
