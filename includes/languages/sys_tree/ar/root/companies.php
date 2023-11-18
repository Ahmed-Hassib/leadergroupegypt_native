<?php

/**
 * function of words in arabic
 */
function companies($phrase, $param = null)
{
  static $lang = array(
  // words

  // large words

  // buttons words

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}