<?php

/**
 * function of words in arabic
 */
function description($phrase)
{
  static $lang = array(
    // words
    'ABSTRACT' => 'نبذ مختصرة',

    // large statements
    'SYSTREE DESC'  => 'هي خدمة تقدمها شركتنا لتسهيل تنظيم وإدارة أجهزة الشبكة والعملاء لديك',
  );
  // return the phrase
  return $lang[$phrase];
}
