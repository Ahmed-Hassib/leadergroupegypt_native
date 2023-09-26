<?php

/**
 * function of words in arabic
 */
function sections($phrase)
{
  static $lang = array(
  // words
  '#SEC' => 'عدد الأقسام',
  'SEC CODE' => 'كود القسم',
  'SEC NAME' => 'إسم القسم',
  'STATUS' => 'حالة القسم',

  // large statements

  // messages
  'ACTIVATED' => 'تم تفعيل القسم بنجاح',
  'DEACTIVATED' => 'تم إلغاء تفعيل القسم بنجاح',

  // buttons words
  'ADD NEW' => 'إضافة قسم جديد',
  'ADD NEW CONTENT' => 'إضافة محتوى جديد',
  'EDIT SECTIONS' => 'تعديل القسم',
  'DELETE SECTION' => 'حذف القسم',
  );
  // return the phrase
  return $lang[$phrase];
}