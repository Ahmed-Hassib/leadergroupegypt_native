<?php

/**
 * function of words in arabic
 */
function dashboard($phrase)
{
  static $lang = array(
  // words
  'SECTIONS' => 'أقسام الموقع',
  'THE SECTIONS' => 'الأقسام',
  'THE SERVICES' => 'الخدمات',
  'IMPORTANT LINKS' => 'الروابط الهامة',
  'GALLERY' => 'معرض الصور',
  'ABOUT US' => 'عن الشركة',
  'FEATURES' => 'المميزات',
  'TEAM MEMBERS' => 'أعضاء الفريق',
  'SPONSOR COMPANY INFO' => 'بيانات الشركة المُمولة',

  // large statements
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}