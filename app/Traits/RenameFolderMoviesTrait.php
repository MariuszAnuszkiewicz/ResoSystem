<?php

namespace ResoSystem\Traits;
use ResoSystem\Movie;

trait RenameFolderMoviesTrait
{

    public function renameContentFolderMovies($documentRoot, $public, $folders)
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
            $outputPrepare = strrchr($exp[$i], "/");
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
            $fullPath = strlen(strrchr($outputDirPrepare, "."));
            $onlyDirImg[] = substr($outputDirPrepare, $startOnlyImgDir, strlen($fullPath) - $onlyTitleLength);
            $imgPath['AfterPublicPath'][] = $onlyDirImg[$i];
            $extensionFile['extension'][] = $prepareExtensions[$i];
        }

        $arguments = [];
        for ($i = 0; $i < count($outputDir); $i++) {
            $titlePrepare = implode("|", $outputDir);
            $exp = explode("|", $titlePrepare);
            $titles = strrchr($exp[$i], "/");
            $explodeTitles[] = explode("/", $titles);
            $arguments[] = $i;
        }

        $movies = Movie::whereIn('name', $arguments)->get();
        foreach ($movies as $movie) {
            $ids[] = $movie->id;
            $titlesFromDatabase[] = $movie->name;
        }

        for ($i = 0; $i < count($ids); $i++) {
            rename($public . $outputDir[$i], $public . $imgPath['AfterPublicPath'][$i] . 'movie-' . $titlesFromDatabase[$i] . $extensionFile['extension'][$i]);
        }
    }
}