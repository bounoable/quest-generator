<?php

namespace Bounoable\Quest;

use JsonSerializable;
use Bounoable\Quest\Support\DataException;
use Bounoable\Quest\Support\ValidatesScalarData;

abstract class GeneratedObject implements JsonSerializable
{
    use ValidatesScalarData;

    /**
     * The data.
     *
     * @var array
     */
    private $data = [];

    /**
     * Create a GeneratedMission or GeneratedReward.
     */
    public function __construct(array $data = [])
    {
        if (!$this->validate($data)) {
            throw new DataException('The provided data is not scalar.');
        }

        $this->data = $data;
    }

    /**
     * Get the data.
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Transform the object into an array.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Transform the object into an array.
     */
    abstract public function toArray(): array;
}
