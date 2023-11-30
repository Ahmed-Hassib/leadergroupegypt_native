<?php

/**
 * function of words in arabic
 */
function dashboard_root($phrase, $param = null)
{
  static $lang = array(
  // words
  'WORKING' => 'في العمل',
  'COMPANY' => 'شركة',
  'THE COMPANY' => 'الشركة',
  'COMPANIES' => 'شركات',
  'THE COMPANIES' => 'الشركات',
  '#COMPANIES' => 'عدد الشركات',
  '#REGISTERED COMPANIES' => 'عدد الشركات المُسجلة',

  // large words

  // buttons words

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}