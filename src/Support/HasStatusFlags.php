<?php

namespace Bounoable\Quest\Support;

use Doctrine\ORM\Mapping as ORM;

trait HasStatusFlags
{
    /**
     * The status bitmask.
     *
     * @ORM\Column(type="integer")
     * @var int
     */
    private $status = 0;

    /**
     * Get the status mask.
     */
    public function getStatusMask(): int
    {
        return $this->status;
    }

    /**
     * Determine if the object has a status flag.
     */
    public function hasFlag(int $flag): bool
    {
        return ($this->getStatusMask() & $flag) === $flag;
    }

    /**
     * Add a status flag.
     */
    public function addFlag(int $flag): void
    {
        $this->status |= $flag;
    }

    /**
     * Remove a status flag.
     */
    public function removeFlag(int $flag): void
    {
        $this->status &= ~$flag;
    }
}
