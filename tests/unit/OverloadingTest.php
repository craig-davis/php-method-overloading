<?php
namespace OverloadingTests\unit;

use OverloadingTests\Example\Cart;
use OverloadingTests\Example\Item;
use PHPUnit\Framework\TestCase;

class OverloadingTest extends TestCase
{
    public function testCanUseTrait()
    {
        $item = new Item;
        $id   = 9989;
        $desc = 'New product description';

        $mock = $this->getMockBuilder(Cart::class)
            ->setMethods([
                'addItemByClass',
                'addItemById',
                'addItemByDescription',
            ])
            ->getMock();

        $mock
            ->expects($this->once())
            ->method('addItemByClass')
            ->with($this->identicalTo($item));

        $mock
            ->expects($this->once())
            ->method('addItemById')
            ->with($this->identicalTo($id));

        $mock
            ->expects($this->once())
            ->method('addItemByDescription')
            ->with($this->identicalTo($desc));

        $mock
            ->addItem($item)
            ->addItem($id)
            ->addItem($desc);
    }
}
