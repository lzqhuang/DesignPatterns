<?php

abstract class Journey
{
    /**
     * @var string[]
     */
    private $thingsToDo = [];

    /**
     * 这是当前类及其子类提供的公共服务
     * 注意，它「冻结」了全局的算法行为
     * 如果你想重写这个契约，只需要实现一个包含 takeATrip() 方法的接口
     */
    final public function takeATrip()
    {
        $this->thingsToDo[] = $this->buyAFlight();
        $this->thingsToDo[] = $this->takePlane();
        $this->thingsToDo[] = $this->enjoyVacation();
        $buyGift = $this->buyGift();

        if ($buyGift !== null) {
            $this->thingsToDo[] = $buyGift;
        }

        $this->thingsToDo[] = $this->takePlane();
    }

    /**
     * 这个方法必须要实现，它是这个模式的关键点
     */
    abstract protected function enjoyVacation(): string;

    /**
     * 这个方法是可选的，也可能作为算法的一部分
     * 如果需要的话你可以重写它
     *
     * @return null|string
     */
    protected function buyGift()
    {
        return null;
    }

    private function buyAFlight(): string
    {
        return 'Buy a flight ticket';
    }

    private function takePlane(): string
    {
        return 'Taking the plane';
    }

    /**
     * @return string[]
     */
    public function getThingsToDo(): array
    {
        return $this->thingsToDo;
    }
}

class BeachJourney extends Journey
{
    protected function enjoyVacation(): string
    {
        return "Swimming and sun-bathing";
    }
}

class CityJourney extends Journey
{
    protected function enjoyVacation(): string
    {
        return "Eat, drink, take photos and sleep";
    }

    protected function buyGift(): string
    {
        return "Buy a gift";
    }
}

$beachJourney = new BeachJourney();
$beachJourney->takeATrip();

$takeATrip = [
    'Buy a flight ticket',
    'Taking the plane',
    'Swimming and sun-bathing',
    'Taking the plane'];
var_dump($takeATrip === $beachJourney->getThingsToDo());


$cityJourney = new CityJourney();
$cityJourney->takeATrip();

$takeATrip = [
    'Buy a flight ticket',
    'Taking the plane',
    'Eat, drink, take photos and sleep',
    'Buy a gift',
    'Taking the plane'
];

var_dump($takeATrip === $cityJourney->getThingsToDo());