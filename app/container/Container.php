<?php declare(strict_types=1);

namespace App\Container;

use App\Container\Exceptions\ContainerException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $entries = [];

    /**
     * @param string $id
     * @return mixed|object|null
     * @throws ContainerException
     */
    public function get(string $id): mixed
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            if (is_callable($entry)) {
                return $entry($this);
            }

            $id = $entry;
        }

        return $this->resolve($id);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    /**
     * @param string $id
     * @param $concrete
     * @return void
     */
    public function set(string $id, $concrete)
    {
        $this->entries[$id] = $concrete;
    }

    /**
     * @param string $id
     * @return mixed|object|null
     * @throws ContainerException
     * @throws ReflectionException
     */
    public function resolve(string $id): mixed
    {
        $reflection = new \ReflectionClass($id);

        if (! $reflection->isInstantiable()) {
            throw new ContainerException('Class ' . $id . ' is not instantiable.');
        }

        $constructor = $reflection->getConstructor();
        if (! $constructor) {
            return new $id;
        }

        $parameters = $constructor->getParameters();
        if (! $parameters) {
            return new $id;
        }

        $dependencies = $this->resolveDependencies($parameters, $id);

        return $reflection->newInstanceArgs($dependencies);
    }

    private function resolveDependencies($parameters, $id): array
    {
        return array_map(
            function (\ReflectionParameter $parameter) use ($id) {
                $name = $parameter->getName();
                $type = $parameter->getType();

                if (! $type) {
                    throw new ContainerException('Parameter name ' . $name . ' is missing a type hint on class ' . $id . '.');
                }

                if ($type instanceof \ReflectionUnionType) {
                    throw new ContainerException('Failed to resolve class ' . $id . ' union type for parameter ' . $name);
                }

                if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
                    return $this->get($type->getName());
                }

                throw new ContainerException('Failed to resolve class ' . $id . ' because invalid param "' . $name . '"');
            },
            $parameters
        );
    }
}
