<?php
namespace Overloading;

trait Overloading
{
    private function __overload(string $overload, array $args)
    {
        $length = strlen($overload);
        $argumentTypes = [];

        foreach (get_class_methods($this) as $method) {
            // Find only methods with matching names, ignore the overloaded name
            if ($method === $overload || substr($method, 0, $length) !== $overload) {
                continue;
            }

            $reflection = new \ReflectionMethod($this, $method);

            // The number of arguments is incorrect
            if (count($args) < $reflection->getNumberOfRequiredParameters()) {
                continue;
            }

            // The argument types match
            $parameterTypes = [];
            foreach ($reflection->getParameters() as $parameter) {
                $parameterTypes[$parameter->getPosition()] = (string) $parameter->getType();
            }

            if (empty($argumentTypes)) {
                foreach ($args as $arg) {
                    $argumentTypes[] = $this->getHintType($arg);
                }
            }

            // TODO Handle partial matches for optional parameters
            if ($parameterTypes === $argumentTypes) {
                return call_user_func_array([$this, $method], $args);
            }
        }

        throw new \LogicException('Incorrect type options for '.$overload);
    }

    private function getHintType($var)
    {
        if (is_array($var)) return "array";
        if (is_bool($var)) return "bool";
        if (is_float($var)) return "float";
        if (is_int($var)) return "int";
        if (is_null($var)) return "NULL";
        if (is_numeric($var)) return "numeric";
        if (is_object($var)) return get_class($var);
        if (is_resource($var)) return "resource";
        if (is_string($var)) return "string";
        return "unknown type";
    }
}
