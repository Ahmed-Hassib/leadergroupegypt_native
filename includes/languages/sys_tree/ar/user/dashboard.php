<?php

/**
 * function of words in arabic
 */
function dashboard($phrase)
{
  static $lang = array(
    'DASHBOARD' => 'لوحة التحكم',
    'LOGIN' => 'تسجيل الدخول',
    'SIGNUP' => 'تسجيل جديد',
    'SEARCH FEATURE' => 'خاصية البحث',

    // large global words
    'SEARCH HERE' => 'ابحث عن ما تريد هنا',
    'GO TO INTRO VIDEO' => 'الذهاب لفيديو التعريف',
    'SEARCH FEATURE NOTE' => 'يتيح لك البرنامج امكانية البحث عن ما تريد حيث يعتمد البحث في البرنامج علي البحث في كافة اقسام النظام مما يسهل علي المستخدم الوصول السريع لما يريد.',

    // global messages
    'LOGIN SUCCESS' => 'تسجيل دخول ناجح',
    'LOGIN FAILED' => 'تسجيل دخول خاطئ',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
