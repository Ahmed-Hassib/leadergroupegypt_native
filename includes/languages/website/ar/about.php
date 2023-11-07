<?php

/**
 * function of words in arabic
 */
function about($phrase)
{
  static $lang = array(
  // words
  'TEXT'            => 'النص',
  'AR TEXT'         => 'النص باللغة العربية',
  'EN TEXT'         => 'النص باللغة الانجليزية',
  'STATUS'          => 'حالة النص',
  'TEXT INFO'       => 'بيانات النص',
  'SELECT STATUS'   => 'إختر حالة النص',

  // large statements

  // messages
  'SOME EMPTY'      => 'يوجد بعض الحقول الفارغة في بعض النصوص المُضافة برجاء التأكد من ملئها',
  'INSERTED'        => 'تم إضافة جميع النصوص بنجاح',
  'INSERTED SOME'   => 'تم إضافة بعض النصوص بنجاح',
  'FAILED'          => 'حدث خطأ أثناء إضافة جميع النصوص',
  'FAILED SOME'     => 'حدث خطأ أثناء إضافة بعض النصوص',
  'UPDATED'         => 'تم تعديل النص بنجاح',
  'DELETED'         => 'تم حذف النص بنجاح',
  'ACTIVATED'       => 'تم تفعيل النص بنجاح',
  'DEACTIVATED'     => 'تم إلغاء تفعيل النص بنجاح',
  'AR TEXT RMPTY'   => 'النص باللغة العربية فارغ',
  'EN TEXT RMPTY'   => 'النص باللغة الإنجليزية فارغ',
  'STATUS RMPTY'    => 'حالة النص لم تُحدد',
  'TEXT RMPTY'      => 'لم يتم ادخال النص',

  // buttons words
  'ADD NEW' => 'إضافة نص جديد',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}