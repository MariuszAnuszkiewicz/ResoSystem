<?php

namespace ResoSystem\Traits;
use ResoSystem\Music;

trait ContentMusicsTrait {

    public function loadContentAllMusics($documentRoot, array $folders)
    {
        for ($i = 0; $i < count($folders); $i++) {
            $listFiles[] = glob($documentRoot . $folders[$i] . "*");
            $prepareFiles[] = $listFiles[$i];
            $quantity[] = count($listFiles[$i]);
        }

        for ($i = 0; $i < $quantity[0]; $i++) {
            $titlesRaw[] = substr(strstr($prepareFiles[0][$i], "-"), 1, strlen($prepareFiles[0][$i]));
        }

        for ($i = 0; $i < $quantity[0]; $i++) {
            $imagesRaw[] = substr(strstr($prepareFiles[0][$i], "music"), strlen("music--"), strlen($prepareFiles[0][$i]));
        }

        $range = range(0, $quantity[0]);
        $musicDb = Music::whereIn('id', $range)->paginate(Music::PER_PAGE);
        foreach ($musicDb as $key => $music) {
            $musicsRaw[] = $music;
        }
        sort($titlesRaw);
        $images = $imagesRaw;
        $titles = $titlesRaw;
        $musics = $musicsRaw;

        return [$images, $titles, $musics];
    }
}