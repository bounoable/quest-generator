<?php

namespace Bounoable\Quest;

use JsonSerializable;

interface Mission extends JsonSerializable
{
    /**
     * Get the mission type.
     */
    public function getType(): string;

    /**
     * Determine if the mission has been completed.
     */
    public function isCompleted(): bool;
}
