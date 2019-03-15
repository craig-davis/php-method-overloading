<?php
namespace OverloadingTests\unit;

use OverloadingTests\Example\Cart;
use OverloadingTests\Example\Item;
use PHPUnit\Framework\TestCase;

class OverloadingTest extends TestCase
{
    public function testCanUseTrait()
    {
        $item  = new Item;
        $id    = 9989;
        $desc  = 'Chocolate Candybar';
        $price = 1.53;

        $cart = $this->getMockBuilder(Cart::class)
            ->setMethods([
                'addItemByClass',
                'addItemById',
                'addItemByDescription',
            ])
            ->getMock();

        $cart
            ->expects($this->once())
            ->method('addItemByClass')
            ->with($this->identicalTo($item));

        $cart
            ->expects($this->once())
            ->method('addItemById')
            ->with($this->identicalTo($id));

        $cart
            ->expects($this->once())
            ->method('addItemByDescription')
            ->with(
                $this->identicalTo($desc),
                $this->identicalTo($price)
            );

        $cart
            ->addItem($item)
            ->addItem($id)
            ->addItem($desc, $price);
    }
}
