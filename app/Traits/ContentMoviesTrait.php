<?php

namespace ResoSystem\Traits;
use ResoSystem\Movie;

trait ContentMoviesTrait {

    public function loadContentAllMovies($documentRoot, array $folders)
    {
        for ($i = 0; $i < count($folders); $i++) {
            $listFiles[] = glob($documentRoot . $folders[$i] . "*");
            $prepareFiles[] = $listFiles[$i];
            $quantity[] = count($listFiles[$i]);
        }

        for ($i = 0; $i < $quantity[0]; $i++) {
            $pattern = strstr($prepareFiles[0][$i], "-");
            $end = strlen(strrchr($prepareFiles[0][$i], ".")) + 1;
            $titlesRaw[] = substr($pattern, 1, strlen($pattern) - $end);
        }

        for ($i = 0; $i < $quantity[0]; $i++) {
            $imagesRaw[] = substr(strstr($prepareFiles[0][$i], "movie"), strlen("movie--"), strlen($prepareFiles[0][$i]));
        }

        $range = range(0, $quantity[0]);
        $movieDb = Movie::whereIn('id', $range)->paginate(Movie::PER_PAGE);
        foreach ($movieDb as $key => $movie) {
            $moviesRaw[] = $movie;
        }

        $images = $imagesRaw;
        $titles = $titlesRaw;
        $movies = $moviesRaw;

        return [$images, $titles, $movies];
    }
}