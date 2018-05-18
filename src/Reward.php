<?php

namespace Bounoable\Quest;

interface Reward
{
    /**
     * Get the reward type.
     */
    public function getType(): string;

    /**
     * Transform the mission into an array of mission data.
     */
    public function toArray(): array;
}
