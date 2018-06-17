<?php

namespace Bounoable\Quest;

class RewardTypeManager extends TypeManager
{
    /**
     * Resolve a reward type.
     */
    public function resolve(string $name): RewardType
    {
        return parent::resolve($name);
    }
}
