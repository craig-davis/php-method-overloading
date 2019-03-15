<?php
namespace Overloading;

trait Overloading
{
    private function __overload(string $overload, array $args)
    {
        $length = strlen($overload);
        $argumentTypes = [];

        foreach (get_class_methods($this) as $method) {
            // Find only classes in the form of $method+SomeOtherName
            if ($method === $overload || substr($method, 0, $length) !== $overload) {
                continue;
            }

            // Skip if we don't match the parameter count
            $reflection = new \ReflectionMethod($this, $method);
            if (count($args) !== $reflection->getNumberOfRequiredParameters()) {
                continue;
            }

            // Populate the types, cache when possible
            $parameterTypes = $this->getParameterTypes($reflection);
            $argumentTypes  = $argumentTypes ?: $this->getArgumentTypes($args);

            // Call the method if we have a match
            if ($parameterTypes === $argumentTypes) {
                return call_user_func_array([$this, $method], $args);
            }
        }

        // No appropriate delegate was found, throw an exception
        throw new \LogicException(sprintf(
            'No delegate found for %s with params: %s',
            $overload,
            implode(',', $argumentTypes)
        ));
    }

    private function getParameterTypes(\ReflectionMethod $method)
    {
        $types = [];
        foreach ($method->getParameters() as $parameter) {
            $types[$parameter->getPosition()] = (string) $parameter->getType();
        }

        return $types;
    }

    private function getArgumentTypes(array $args)
    {
        $types = [];
        foreach ($args as $arg) {
            $types[] = $this->convertTypeToHint($arg);
        }

        return $types;
    }

    private function convertTypeToHint($var)
    {
        $typeMap = [
            'array'   => 'array',
            'boolean' => 'bool',
            'double'  => 'float',
            'integer' => 'int',
            'object'  => 'object',
            'string'  => 'string',
        ];

        $type = gettype($var);

        if (!array_key_exists($type, $typeMap)) {
            throw new \LogicException('Unsupported type hint: '.$type);
        }

        $type = $typeMap[$type];

        if ($type == 'object') {
            $type = get_class($var);
        }

        return $type;
    }
}
