<?php
namespace Overloading;

trait Overloading
{
    private function __overload(string $overload, array $args)
    {
        foreach (get_class_methods($this) as $method) {
            // Find only methods with matching names
            if (substr($method, 0, strlen($overload)) !== $overload) {
                continue;
            }

            // TODO: Check for length of required params
            // TODO: Check for correct param types

            if (true) {
                return call_user_func_array([$this, '$method'], $args);
            }
        }

        throw new \LogicException('Incorrect type options for '.$overload);
    }
}
