<?php


class Book {
   
    private $title;
    private $author;
    private $year;

 
    public function __construct($title, $author, $year) {
        $this->title  = $title;
        $this->author = $author;
        $this->year   = $year;
    }

   
    public function getDetails() {
        return "Title: {$this->title}, Author: {$this->author}, Year: {$this->year}";
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setYear($year) {
        $this->year = $year;
    }
}





$book1 = new Book("Clean Code", "Robert C. Martin", 2008);


echo "Initial Book Details:\n";
echo $book1->getDetails() . "\n\n";


$book1->setTitle("The Pragmatic Programmer");
$book1->setAuthor("Andrew Hunt");
$book1->setYear(1999);

echo "Updated Book Details:\n";
echo $book1->getDetails() . "\n\n";

echo "Another Book Example:\n";
$book2 = new Book("PHP 8 Objects, Patterns, and Practice", "Matt Zandstra", 2021);
echo $book2->getDetails() . "\n";

?>