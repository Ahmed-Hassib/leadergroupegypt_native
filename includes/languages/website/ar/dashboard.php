<?php

/**
 * function of words in arabic
 */
function dashboard($phrase)
{
  static $lang = array(
    // words
    'SECTIONS'          => 'أقسام الموقع',
    'THE SECTIONS'      => 'الأقسام',
    'THE SERVICES'      => 'الخدمات',
    'IMPORTANT LINKS'   => 'الروابط الهامة',
    'GALLERY'           => 'معرض الصور',
    'ABOUT US'          => 'عن الشركة',
    'FEATURES'          => 'المميزات',

    // large statements
  );
  // return the phrase
  return $lang[$phrase];
}
