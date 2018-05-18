<?php

namespace Bounoable\Quest;

use Bounoable\Quest\Support\HasStatusFlags;

class BaseMission implements Mission
{
    use HasStatusFlags;

    const COMPLETED = 1 << 0;

    /**
     * Determine if the mission has been completed.
     */
    public function isCompleted(): bool
    {
        return $this->hasFlag(self::COMPLETED);
    }

    /**
     * Set the mission status to completed.
     */
    public function complete(): void
    {
        $this->addFlag(self::COMPLETED);
    }

    /**
     * Transform the mission into an array of mission data.
     */
    public function toArray(): array
    {
        return [
            'completed' => $this->isCompleted()
        ];
    }
}
