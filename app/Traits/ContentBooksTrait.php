<?php

namespace ResoSystem\Traits;
use ResoSystem\Book;

trait ContentBooksTrait {

    public function loadContentAllBooks($documentRoot, array $folders, $request)
    {
        $page = (int) $request->input('page');

        for ($i = 0; $i < count($folders); $i++) {
            $listFiles[] = glob($documentRoot . $folders[$i] . "*");
            $prepareFiles[] = $listFiles[$i];
            $quantityPrepare[] = count($listFiles[$i]);
        }
        for ($i = 0; $i < count($folders); $i++) {
            for ($j = 0; $j < $quantityPrepare[$i]; $j++) {
                $imagesInFolder[] = substr(strstr($prepareFiles[$i][$j], "books/"), strlen('books/'), strlen(strstr($prepareFiles[$i][$j], "books/")));
            }
        }

        $booksPaginate = Book::paginate(Book::PER_PAGE);
        foreach ($booksPaginate as $book) {
            $ids[] = $book->id;
            $images[] = "book-" . $book->name . '.png';
            $titles[] = $book->name;
        }

        $subfolders = null;
        for ($i = 0; $i < count($images); $i++) {
            $searchPaginate = array_search($images[$i], $images);
        }

        $books = Book::paginate(Book::PER_PAGE);
        if ($page) {
            $switch = ($page == 2) ? ($page - 1) : ($page - 1);
            $folder = substr(strrchr($folders[$switch], 'books'), 6, strlen(strrchr($folders[$switch], 'books')));
            switch ($page) {
                case $page:
                    for ($i = 0; $i < count($images); $i++) {
                        $subfolders[] = "$folder" . $images[$i];
                    }
                    if ($page == 2) {
                        array_pop($subfolders);
                        $folder = substr(strrchr($folders[$page], 'books'), 6, strlen(strrchr($folders[$page], 'books')));
                        $subfolders[] = "$folder" . $images[$searchPaginate];
                    }

                break;
            }
        }

        $booksAll = Book::all();
        foreach ($booksAll as $book) {
            $imagesAll[] = "book-" . $book->name . '.png';
        }

        for ($i = 0; $i < count($imagesAll); $i++) {
            $folder = substr(strrchr($folders[0], 'books'), 6, strlen(strrchr($folders[0], 'books')));
            $subfolders[] = "$folder" . $imagesAll[$i];
        }
        return [$images, $titles, $books, $subfolders];
    }
}