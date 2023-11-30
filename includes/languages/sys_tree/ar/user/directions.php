<?php

/**
 * function of words in arabic
 */
function directions($phrase)
{
  static $lang = array(
  // words
  'LIST' => 'قائمة الإتجاهات',
  'DIR NAME' => 'إسم الإتجاه',
  'DIRECTION' => 'إتجاه',
  'DIRECTIONS' => 'إتجاهات',
  'THE DIRECTION' => 'الإتجاه',
  'THE DIRECTIONS' => 'الإتجاهات',
  'SELECT DIRECTION' => 'إختر الإتجاه',
  'SHOW DIR PCS' => 'عرض أجهزة إتجاه',
  'SHOW DIR UNK' => 'عرض غير معروف في إتجاه',

  // large words
  'CANNOT DELETE' => 'لا يمكن حذف هذا الإتجاه لوجود أكتر من جهاز أو عميل عليه',

  // messages
  'DIRECTION ERROR' => 'إسم الإتجاه لا يمكن أن يكون فارغاً',
  'NAME EXIST' => 'إسم هذا الإتجاه موجود بالفعل',
  'INSERTED' => 'تم إضافة إتجاه جديد بنجاح',
  'UPDATED' => 'تم تعديل بيانات الإتجاه بنجاح',
  'DELETED' => 'تم حذف الإتجاه بنجاح',

  // buttons words
  'ADD NEW' => 'إضافة إتجاه جديد',
  'EDIT DIR' => 'تعديل إتجاه',
  'DELETE DIR' => 'حذف إتجاه',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
