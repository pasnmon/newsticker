<?php

function clean($dirty,$stripTags = true, $encoding="UTF-8"){
    if ($stripTags){
        $dirty = strip_tags($dirty);
    }
    return	htmlspecialchars(
        $dirty,
        ENT_QUOTES	|	ENT_HTML5,
        $encoding
    );
}

function purify($dirt){
    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);

    return $purifier->purify($dirt);
}