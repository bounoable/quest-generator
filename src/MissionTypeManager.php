<?php

namespace Bounoable\Quest;

use Closure;
use Exception;

class MissionTypeManager
{
    /**
     * The mission type resolvers.
     *
     * @var array
     */
    private $resolvers = [];

    /**
     * Resolve a mission type.
     */
    public function resolve(string $typeName): MissionType
    {
        if (!isset($this->resolvers[$typeName])) {
            throw new Exception("MissionType '{$typeName}' has not been registered.");
        }

        return $this->resolvers[$typeName]();
    }

    /**
     * Register a mission type.
     *
     * @param  string  $typeName
     * @param  Closure|MissionType  $type
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
