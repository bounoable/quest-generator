<?php

namespace Bounoable\Quest;

interface Mission
{
    /**
     * Get the mission type.
     */
    public function getType(): string;

    /**
     * Get the mission data.
     */
    public function getData(): array;
}
