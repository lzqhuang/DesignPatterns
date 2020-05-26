<?php

/**
 * 抽象工厂模式
 */

interface Product
{
    public function calculatePrice(): int;
}

class ShippableProduct implements Product
{
    /**
     * @var float
     */
    private $productPrice;
    /**
     * @var float
     */
    private $shippingCosts;
    public function __construct(int $productPrice, int $shippingCosts)
    {
        $this->productPrice = $productPrice;
        $this->shippingCosts = $shippingCosts;
    }
    public function calculatePrice(): int
    {
        return $this->productPrice + $this->shippingCosts;
    }
}

class DigitalProduct implements Product
{
    /**
     * @var int
     */
    private $price;
    public function __construct(int $price)
    {
        $this->price = $price;
    }
    public function calculatePrice(): int
    {
        return $this->price;
    }
}

class ProductFactory
{
    const SHIPPING_COSTS = 50;
    public function createShippableProduct(int $price): Product
    {
        return new ShippableProduct($price, self::SHIPPING_COSTS);
    }
    public function createDigitalProduct(int $price): Product
    {
        return new DigitalProduct($price);
    }
}

$factory = new ProductFactory();
$product = $factory->createDigitalProduct(150);

$factory = new ProductFactory();
$product = $factory->createShippableProduct(150);