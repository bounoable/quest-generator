<?php

namespace Bounoable\Quest;

use Closure;
use Exception;

abstract class TypeManager
{
    /**
     * The registered type resolvers.
     *
     * @var array
     */
    private $types = [];

    /**
     * Resolve a type.
     */
    public function resolve(string $name)
    {
        if (!$this->registered($name)) {
            throw new Exception("Type '{$name}' has not been registered.");
        }

        return $this->resolvers[$name]();
    }

    /**
     * Determine if a type has been registered.
     */
    public function registered(string $name): bool
    {
        return isset($this->resolvers[$name]);
    }

    /**
     * Register a type.
     *
     * @param  string  $name
     * @param  mixed  $type
     * @return void
     */
    public function register(string $name, $type): void
    {
        $resolver = $type instanceof Closure ? $type : function () use ($type) {
            return $type;
        };

        $this->resolvers[$name] = $resolver;
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
