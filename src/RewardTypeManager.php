<?php

namespace Bounoable\Quest;

use Closure;
use Exception;

class RewardTypeManager
{
    /**
     * The reward type resolvers.
     *
     * @var array
     */
    private $resolvers = [];

    /**
     * Resolve a reward type.
     */
    public function resolve(string $typeName): RewardType
    {
        if (!isset($this->resolvers[$typeName])) {
            throw new Exception("RewardType '{$typeName}' has not been registered.");
        }

        return $this->resolvers[$typeName]();
    }

    /**
     * Register a reward type.
     *
     * @param  string  $typeName
     * @param  Closure|RewardType  $type
     * @return void
     */
    public function register(string $typeName, $type): void
    {
        $resolver = $type instanceof Closure ? $type : function () use ($type) {
            return $type;
        };

        $this->resolvers[$typeName] = $resolver;
    }

    /**
     * Get the registered type names.
     *
     * @return string[]
     */
    public function getTypeNames(): array
    {
        return array_keys($this->resolvers);
    }
}
