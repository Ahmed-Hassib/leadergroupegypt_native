<?php

/**
 * function of words in arabic
 */
function companies_root($phrase, $param = null)
{
  static $lang = array(
  // words
  'COMPANY' => 'شركة',
  'THE COMPANY' => 'الشركة',
  'COMPANIES' => 'شركات',
  'THE COMPANIES' => 'الشركات',
  'ACTIVE' => 'يعمل',
  'ACTIVATE' => '',
  'DEACTIVATE' => '',
  '' => '',

  // large words

  // buttons words

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}