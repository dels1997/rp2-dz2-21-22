<?php

require_once __DIR__ . '/../model/libraryservice.class.php';

class BooksController
{
    public function index()
    {
        $booklist = LibraryService::getAllBooks();
        $title = 'Popis svih knjiga';

        require_once __DIR__ . '/../view/books_index.php';
    }

    public function search()
    {
        $title = 'Pretraživanje po imenu autora';
        require_once __DIR__ . '/../view/books_search.php';
    }

    public function searchResults()
    {
        $author = $_POST['author'];

        $booklist = LibraryService::getBooksByAuthor($author);
        $title = 'Popis svih knjiga autora ' . $author;

        require_once __DIR__ . '/../view/books_index.php';
    }

    public function list()
    {
        $id_user = $_GET['id_user'];
        
        $user = LibraryService::getUserByID($id_user);
        
        $booklist = LibraryService::getLoanedBooks($user);

        $title = 'Popis svih knjiga koje je posudio ' . $user->name . ' ' . $user->surname;

        require_once __DIR__ . '/../view/books_index.php';
    }
};

?>