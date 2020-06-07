<?php

class Book
{
    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $title;

    public function __construct(string $title, string $author)
    {
        $this->author = $author;
        $this->title = $title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthorAndTitle(): string
    {
        return $this->getTitle() . ' by ' . $this->getAuthor();
    }
}

class BookList implements \Countable, \Iterator
{
    /**
     * @var Book[]
     */
    private $books = [];

    /**
     * @var int
     */
    private $currentIndex = 0;

    public function addBook(Book $book)
    {
        $this->books[] = $book;
    }

    public function removeBook(Book $bookToRemove)
    {
        foreach ($this->books as $key => $book) {
            if ($book->getAuthorAndTitle() === $bookToRemove->getAuthorAndTitle()) {
                unset($this->books[$key]);
            }
        }

        $this->books = array_values($this->books);
    }

    public function count(): int
    {
        return count($this->books);
    }

    public function current(): Book
    {
        return $this->books[$this->currentIndex];
    }

    public function key(): int
    {
        return $this->currentIndex;
    }

    public function next()
    {
        $this->currentIndex++;
    }

    public function rewind()
    {
        $this->currentIndex = 0;
    }

    public function valid(): bool
    {
        return isset($this->books[$this->currentIndex]);
    }
}

$bookList = new BookList();
$bookList->addBook(new Book('Learning PHP Design Patterns', 'William Sanders'));
$bookList->addBook(new Book('Professional Php Design Patterns', 'Aaron Saray'));
$bookList->addBook(new Book('Clean Code', 'Robert C. Martin'));

$books = [];

foreach ($bookList as $book) {
    $books[] = $book->getAuthorAndTitle();
}

var_dump(
    [
        'Learning PHP Design Patterns by William Sanders',
        'Professional Php Design Patterns by Aaron Saray',
        'Clean Code by Robert C. Martin',
    ] ===
    $books
);

$book = new Book('Clean Code', 'Robert C. Martin');
$book2 = new Book('Professional Php Design Patterns', 'Aaron Saray');

$bookList = new BookList();
$bookList->addBook($book);
$bookList->addBook($book2);
$bookList->removeBook($book);

$books = [];
foreach ($bookList as $book) {
    $books[] = $book->getAuthorAndTitle();
}

var_dump(
    ['Professional Php Design Patterns by Aaron Saray'] ===
    $books
);


$book = new Book('Clean Code', 'Robert C. Martin');

$bookList = new BookList();
$bookList->addBook($book);

var_dump(1 === $bookList->count());

$book = new Book('Clean Code', 'Robert C. Martin');

$bookList = new BookList();
$bookList->addBook($book);
$bookList->removeBook($book);

var_dump(0 === $bookList->count());

