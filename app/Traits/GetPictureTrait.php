<?php

namespace ResoSystem\Traits;

trait GetPictureTrait {

    public function getPictureById($request, $productName, array $folders)
    {
        $documentRoot = $request->server('DOCUMENT_ROOT');
        $filesStr = null;
        for ($i = 0; $i < count($folders); $i++) {
            $files[] = glob($documentRoot . $folders[$i] . "*");
            $filesStr .= implode(", ", $files[$i]) . ", ";
        }
        $exp = explode(", ", $filesStr);
        array_pop($exp);
        $searchImage = null;
        for ($i = 0; $i < count($exp); $i++) {
            if (preg_match("/{$productName}/", $exp[$i])) {
                $searchImage['image'] = strstr($exp[$i], '/images');
            }
        }
        return $searchImage;
    }
}
