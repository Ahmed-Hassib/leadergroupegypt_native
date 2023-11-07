<?php

/**
 * function of words in arabic
 */
function login($phrase)
{
  static $lang = array(
    // words
    'LOGIN'             => 'تسجيل دخول',
    'USERNAME'          => 'إسم المستخدم',
    'EMAIL'             => 'البريد الإلكترونى',
    'PASSWORD'          => 'الرقم السرى',
    'WEBSITE LOGIN'     => 'تسجيل الدخول للموقع',
    

    // large statements


    // messages
    'USERNAME EMPTY' => 'إسم المستخدم فارغ',
    'PASSWORD EMPTY' => 'الرقم السرى فارغ',
    

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
