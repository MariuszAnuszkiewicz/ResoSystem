<?php

namespace ResoSystem\Traits;
use ResoSystem\Book;

trait RenameFolderBooksTrait {

    public function renameContentFolderBooks($documentRoot, $public, $folders)
    {
        for ($i = 0; $i < count($folders); $i++) {
            $listFiles[] = glob($documentRoot . $folders[$i] . "*");
            $prepareFiles[] = $listFiles[$i];
        }
        $prepareFilesStr = null;
        $outputPrepare = null;
        for ($i = 0; $i < count($folders); $i++) {
            $prepareFilesStr .= implode("|", $prepareFiles[$i]);
            $prepareFilesStr .= "|";
        }
        $exp = explode("|", $prepareFilesStr);
        for ($i = 0; $i < count($exp); $i++) {
            $outputPrepare = strrchr($exp[$i],"/");
            $outputPrepare = substr($outputPrepare, 1, strlen($outputPrepare));
            $images[] = $outputPrepare;
        }

        $outputDirPrepare = null;
        $outputDir = null;
        $exp = explode("|", $prepareFilesStr);
        for ($i = 0; $i < count($exp); $i++) {
            $outputDirStr = implode("|", $exp);
            $start = strlen(strtok($outputDirStr, "/"));
            $outputDirPrepare = $exp[$i];
            $onlyTitleLength = strlen(strrchr($outputDirPrepare, "/"));
            $outputDir[] = substr($outputDirPrepare, $start, strlen($exp[$i]));
            $prepareExtensions[] = strrchr($outputDir[$i], ".");
            $startOnlyImgDir = strlen(strtok($outputDirStr, "/"));
            $fullPath =  strlen(strrchr($outputDirPrepare, "."));
            $onlyDirImg[] = substr($outputDirPrepare, $startOnlyImgDir, strlen($fullPath) - $onlyTitleLength);
            $imgPath['AfterPublicPath'][] = $onlyDirImg[$i];
            $extensionFile['extension'][] = $prepareExtensions[$i];
        }
        for ($i = 0; $i < count($exp); $i++) {
            $cutExtension = strlen(strstr($images[$i], "."));
            $compare[] = substr($images[$i], 0, strlen($images[$i]) - $cutExtension);
        }

        $booksOrder = Book::orderBy('id', 'ASC')->get();
        $arr = [];
        foreach ($booksOrder as $book) {
            $arr[] = $book->name;
        }

        $listOrderByFiles = [];
        for ($i = 0; $i < count($arr); $i++) {
            if ($compare[$i] == $arr[$i]) {
                $listOrderByFiles[] = $compare;
            }
        }
        if (!empty($listOrderByFiles)) {
            array_pop($listOrderByFiles[0]);
        }
        $arguments = [];
        for ($i = 0; $i < count($outputDir); $i++) {
            $titlePrepare = implode("|", $outputDir);
            $exp = explode("|", $titlePrepare);
            $titles = strrchr($exp[$i], "/");
            $explodeTitles[] = explode("/", $titles);
            $arguments[] = $i;
        }

        $books = Book::whereIn('name', $arguments)->get();
        foreach ($books as $book) {
            $ids[] = $book->id;
        }

        for ($i = 0; $i < count($ids); $i++) {
            if(!empty($listOrderByFiles)) {
                rename($public . $outputDir[$i], $public . $imgPath['AfterPublicPath'][$i] . 'book-' . $listOrderByFiles[0][$i] . $extensionFile['extension'][$i]);
            }
        }
    }
}