<?php

namespace Bounoable\Quest;

abstract class GeneratedType extends GeneratedObject
{
    /**
     * The type.
     *
     * @var string
     */
    private $type;

    /**
     * Create a GeneratedMission or GeneratedReward.
     */
    public function __construct(string $type, array $data = [])
    {
        parent::__construct($data);
        $this->type = $type;
    }

    /**
     * Get the type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Transform the object into an array.
     */
    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'data' => $this->getData(),
        ];
    }
}
