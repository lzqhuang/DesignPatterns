<?php

/**
 * 简单工厂模式
 */

class SimpleFactory
{
    public function createBicycle(): Bicycle
    {
        return new Bicycle();
    }

    public function createFlight(): Flight
    {
        return new Flight();
    }
}

class Bicycle
{
    public function driveTo(string $destination)
    {
        echo $destination;
    }
}

class Flight
{
    public function driveTo(string $destination)
    {
        echo $destination;
    }
}

$factory1 = new SimpleFactory();
$bicycle = $factory1->createBicycle();
$bicycle->driveTo('Paris');


$factory2 = new SimpleFactory();
$flight = $factory2->createFlight();
$flight->driveTo('Paris');