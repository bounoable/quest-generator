<?php

namespace Bounoable\Quest;

interface Mission
{
    /**
     * Get the mission type.
     */
    public function getType(): string;

    /**
     * Determine if the mission has been completed.
     */
    public function isCompleted(): bool;

    /**
     * Transform the mission into an array of mission data.
     */
    public function toArray(): array;
}
