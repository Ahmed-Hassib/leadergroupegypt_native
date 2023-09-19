<?php

/**
 * function of words in arabic
 */
function links($phrase)
{
  static $lang = array(
    // words
    'IMPORTANT LINKS'     => 'الروابط الهامة',
    'LINK'                => 'الرابط',
    'AR NAME'             => 'الإسم باللغة العربية',
    'EN NAME'             => 'الإسم باللغة الانجليزية',
    'STATUS'              => 'حالة الرابط',
    'LINK INFO'           => 'بيانات الرابط',
    'SELECT STATUS'       => 'إختر حالة العطل',

    // large statements

    // messages
    'SOME EMPTY'      => 'يوجد بعض الحقول الفارغة في بعض الروابط المُضافة برجاء التأكد من ملئها',
    'INSERTED'        => 'تم إضافة جميع الروابط بنجاح',
    'INSERTED SOME'   => 'تم إضافة بعض الروابط بنجاح',
    'FAILED'          => 'حدث خطأ أثناء إضافة جميع الروابط',
    'FAILED SOME'     => 'حدث خطأ أثناء إضافة بعض الروابط',
    'UPDATED'         => 'تم تعديل الرابط بنجاح',
    'DELETED'         => 'تم حذف الرابط بنجاح',
    'ACTIVATED'       => 'تم تفعيل الرابط بنجاح',
    'DEACTIVATED'     => 'تم إلغاء تفعيل الرابط بنجاح',
    'AR NAME RMPTY'   => 'الإسم باللغة العربية فارغ',
    'EN NAME RMPTY'   => 'الإسم باللغة الإنجليزية فارغ',
    'STATUS RMPTY'    => 'حالة الرابط لم تُحدد',
    'LINK RMPTY'      => 'لم يتم ادخال الرابط',

    // buttons words
    'ADD NEW' => 'إضافة رابط جديد',

  );
  // return the phrase
  return $lang[$phrase];
}
