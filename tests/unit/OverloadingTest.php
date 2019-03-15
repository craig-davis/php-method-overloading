<?php
namespace OverloadingTests\unit;

use Overloading\Overloading;
use PHPUnit\Framework\TestCase;

class OverloadingTest extends TestCase
{
    public function testCanUseTrait()
    {
        (new class {
            use Overloading;
        });
    }
}
