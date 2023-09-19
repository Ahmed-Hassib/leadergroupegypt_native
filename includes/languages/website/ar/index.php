<?php

/**
 * function of words in arabic
 */
function index($phrase)
{
  static $lang = array(
    // words
    'RECENT ARTICLES' => 'احدث المقالات',
    'GALLERY'         => 'المعرض',
    'FEATURES'        => 'المميزات',
    'OUR WHEREABOUTS' => 'أماكن تواجدنا',
    'ABOUT US'        => 'عن الشركة',


    // large statements
    'WELCOME TO' => 'مرحباً بكم في ',
    'CHOOSE SERVICE OF BUSINESS' => 'إختر خدمتك بناءً علي احتياجاتك وسوف نساعدك ونعمل علي تطويرها بشكل دائم'

  );
  // return the phrase
  return $lang[$phrase];
}