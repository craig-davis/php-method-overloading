PHP Method Overloading
================================================================================

Add the `Overloading` trait to a class to help implement type hinted overloading and delegation.

```php
$cart
    ->addItem(new Item(1))
    ->addItem(1)
    ->addItem('A candybar', 1.53);
```

Delegates correctly to implementation for each parameter signature. 

```php
public function addItem(...$args);

protected function addItemByClass(Item $item);
protected function addItemById(int $id);
protected function addItemByDescription(string $description, float $price);
```
