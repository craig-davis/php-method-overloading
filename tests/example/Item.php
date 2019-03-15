<?php
namespace OverloadingTests\Example;

class Item
{
    public function setPrice(float $price)
    {
        return $this;
    }

    public function setDescription(string $description)
    {
        return $this;
    }
}
