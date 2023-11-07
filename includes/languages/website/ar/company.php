<?php

/**
 * function of words in arabic
 */
function company($phrase)
{
  static $lang = array(
  // words
  'COMPANY DESC' => 'نبذة عن الشركة',
  'JOB DETAILS' => 'تفاصيل العمل',
  'AR DESC' => 'الوصف باللغة العربية',
  'EN DESC' => 'الوصف باللغة الإنجليزية',
  'AR ADDR' => 'العنوان باللغة العربية',
  'EN ADDR' => 'العنوان باللغة الإنجليزية',
  'START JOB TIME' => 'بداية ساعات العمل',
  'END JOB TIME' => 'نهاية ساعات العمل',
  'PHONES DETAILS' => 'بيانات التليفونات',

  // large statements

  // messages
  'INSERTED' => 'تم إضافة جميع البيانات بنجاح',
  'UPDATED' => 'تم تعديل جميع البيانات بنجاح',
  'PHONES INSERTED' => 'تم إضافة جميع أرقام التليفونات بنجاح',
  'PHONES SOME INSERTED' => 'تم إضافة بعض أرقام التليفونات بنجاح وحدث خطأ أثناء إضافة باقى الأرقام',
  'PHONES DELETED' => 'تم حذف جميع أرقام التليفونات بنجاح',

  // buttons words
  'ADD NEW PHONE' => 'إضافة تليفون جديد',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}