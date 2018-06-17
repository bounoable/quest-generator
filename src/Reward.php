<?php

namespace Bounoable\Quest;

interface Reward
{
    /**
     * Get the reward type.
     */
    public function getType(): string;

    /**
     * Get the reward data.
     */
    public function getData(): array;
}
