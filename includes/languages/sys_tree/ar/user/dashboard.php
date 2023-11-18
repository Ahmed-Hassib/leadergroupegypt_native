<?php

/**
 * function of words in arabic
 */
function dashboard($phrase)
{
  static $lang = array(
    'LOGIN'             => 'تسجيل الدخول',
    'SIGNUP'            => 'تسجيل جديد',

    // large global words
    'DON`T HAVE ACCOUNT'  => 'لا تمتلك حساب',

    // global messages
    'LOGIN SUCCESS'     => 'تسجيل دخول ناجح',
    'LOGIN FAILED'      => 'تسجيل دخول خاطئ',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
