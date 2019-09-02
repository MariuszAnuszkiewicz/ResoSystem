<?php

namespace BookStore\Traits;

trait JsonCreateBooksTableTrait {

    public function jsonCreateToBooksTable($publishingHouseId, $title, $isbn, $yearOfPublication, $describe, $amount)
    {
        $path = storage_path() . "/json/books.json";
        $fileToRead = fopen($path, "r");
        $fileToWrite = fopen($path, "c");
        $output = [
            'books' => [
                'publishing_house_id' => $publishingHouseId,
                'title' => $title,
                'isbn' => $isbn,
                'year_of_publication' => $yearOfPublication,
                'describe' => $describe,
                'amount' => $amount
            ]
        ];

        $read = stream_get_contents($fileToRead, filesize($path), 0);
        if (preg_match('/books/', $read)) {
            foreach ($output as $key => $val) {
                $arr = [$key => [$val]];
                $offset = strlen($key) + 11;
                $source = json_encode($arr, JSON_PRETTY_PRINT);
                $final = ",";
                $final .= substr($source, $offset, strlen($source));
                fseek($fileToWrite, strlen($read) - 3);
                fwrite($fileToWrite, $final);
                fclose($fileToWrite);
            }

        } else {
            foreach ($output as $key => $val) {
                $arr = [$key => [$val]];
                $source = json_encode($arr, JSON_PRETTY_PRINT);
                fwrite($fileToWrite, $source);
                fclose($fileToWrite);
            }
        }
    }
}