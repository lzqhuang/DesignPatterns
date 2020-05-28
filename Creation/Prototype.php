<?php

abstract class BookPrototype
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $category;

    abstract public function __clone();

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
}

class BarBookPrototype extends BookPrototype
{
    /**
     * @var string
     */
    protected $category = 'Bar';

    public function __clone()
    {
    }
}

class FooBookPrototype extends BookPrototype
{
    /**
     * @var string
     */
    protected $category = 'Foo';

    public function __clone()
    {
    }
}

$fooPrototype = new FooBookPrototype();
$barPrototype = new BarBookPrototype();
$book = clone $fooPrototype;

for ($i = 0; $i < 10; $i++) {
    $book = clone $fooPrototype;
    $book->setTitle('Foo Book No ' . $i);
    if (FooBookPrototype::class instanceof $book) {
        echo true;
    }
}