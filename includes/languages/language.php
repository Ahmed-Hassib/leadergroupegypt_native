<?php

// include_once languages files
include_once "arabic.php";
include_once "english.php";
/**
 * 
 */
function language($phrase, $lang = "ar") {
    // return the word
    return $lang == "en" ?  languageEn($phrase) : languageAr($phrase);
}
