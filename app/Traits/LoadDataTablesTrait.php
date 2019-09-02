<?php

namespace ResoSystem\Traits;

trait LoadDataTablesTrait {

    public function loadTablesFromJson($book, $movie, $music)
    {
        $path = storage_path() . "/json/books.json";
        $jsonData = json_decode(file_get_contents($path), true);
        foreach ($jsonData as $key => $json) {
            $jsonArray['keys'] = array_keys($json[0]);
            $jsonArray['rows'] = $jsonData[$key];
        }
        if ($book::count() == 0) {
            for ($i = 0; $i < count($jsonArray['rows']); $i++) {
                $joinValues = implode("|", array_values($jsonArray['rows'][$i]));
                $arguments = explode("|", $joinValues);
                list ($name, $isbn_number, $price) = $arguments;
                $book->insertDataToBooksTable($name, $isbn_number, $price);
            }
        }

        $path = storage_path() . "/json/movies.json";
        $jsonData = json_decode(file_get_contents($path), true);
        foreach ($jsonData as $key => $json) {
            $jsonArray['keys'] = array_keys($json[0]);
            $jsonArray['rows'] = $jsonData[$key];
        }
        if ($movie::count() == 0) {
            for ($i = 0; $i < count($jsonArray['rows']); $i++) {
                $joinValues = implode("|", array_values($jsonArray['rows'][$i]));
                $arguments = explode("|", $joinValues);
                list ($name, $data_carrier, $price) = $arguments;
                $movie->insertDataToMoviesTable($name, $data_carrier, $price);
            }
        }

        $path = storage_path() . "/json/musics.json";
        $jsonData = json_decode(file_get_contents($path), true);
        foreach ($jsonData as $key => $json) {
            $jsonArray['keys'] = array_keys($json[0]);
            $jsonArray['rows'] = $jsonData[$key];
        }
        if ($music::count() == 0) {
            for ($i = 0; $i < count($jsonArray['rows']); $i++) {
                $joinValues = implode("|", array_values($jsonArray['rows'][$i]));
                $arguments = explode("|", $joinValues);
                list ($name, $data_carrier, $price) = $arguments;
                $music->insertDataToMusicsTable($name, $data_carrier, $price);
            }
        }
    }
}