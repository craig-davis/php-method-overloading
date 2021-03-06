PHP Method Overloading [![Build Status](https://travis-ci.org/craig-davis/php-method-overloading.svg?branch=master)](https://travis-ci.org/craig-davis/php-method-overloading)
================================================================================

> This is a proof of concept and should not be considered for production use.

Add the `Overloading` trait to a class to help implement type hinted overloading and delegation.

```php
$cart
    ->addItem(new Item(1))
    ->addItem(1)
    ->addItem('A candybar', 1.53);
```

Delegates correctly to an implementation for each parameter signature.

```php
public function addItem(...$args);

protected function addItemByClass(Item $item);
protected function addItemById(int $id);
protected function addItemByDescription(string $description, float $price);
```

