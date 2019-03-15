<?php
namespace OverloadingTests\Example;

use Overloading\Overloading;

class Cart
{
    use Overloading;

    private $items = [];

    public function cartSize(): int
    {
        return count($this->items);
    }

    public function addItem(...$args) {
        $this->__overload(__FUNCTION__, $args);

        return $this;
    }

    protected function addItemByClass(Item $item)
    {
        $this->items[] = $item;
    }

    protected function addItemById(int $itemId)
    {
        $this->items[] = app(StockLocator::class)->with($itemId);
    }

    protected function addItemByDescription(string $description, float $price)
    {
        $this->items[] = (new Item)
            ->setDescription($description)
            ->setPrice($price);
    }
}

/* End of file Cart.php */
