<?php
namespace OverloadingTests\Example;

use Overloading\Overloading;

class Cart
{
    use Overloading;

    private $items = [];

    public function addItem(...$args) {
        $this->__overload(__FUNCTION__, $args);
    }

    private function addItemByClass(Item $item)
    {
        $this->items[] = $item;
    }

    private function addItemById(int $itemId)
    {
        $this->items[] = app(StockLocator::class)->with($itemId);
    }

    private function addItemByDescription(string $description)
    {
        $this->items[] = new Item($description);
    }
}

/* End of file Cart.php */
