<?php

/**
 * function of words in arabic
 */
function team($phrase)
{
  static $lang = array(
  // words
  'MEMBER INFO' => 'بيانات العضو',
  '#MEMBER' => 'عدد الأعضاء',
  'MEMBER CODE' => 'كود العضو',
  'MEMBER NAME' => 'إسم العضو',
  'JOB TITLE' => 'وظيفة العضو',
  'SOCIAL MEDIA' => 'وسائل التواصل',
  'IMAGE' => 'صورة العضو',
  'STATUS' => 'حالة العضو',
  'CHANGE IMG' => 'تغيير صورة العضو',
  'SELECT STATUS' => 'إختر حالة العضو',

  // large statements

  // messages
  'ID EMPTY' => 'توجد بعض الحقول فارغة',
  'ACTIVATED' => 'تم تفعيل العضو بنجاح',
  'DEACTIVATED' => 'تم إلغاء تفعيل العضو بنجاح',
  'STATUS EMPTY' => 'حالة العضو لم ثُحدد',
  'IMG EMPTY' => 'صورة العضو لم تُحدد',
  'INSERTED' => 'تم إضافة كل الأعضاء بنجاح',
  'INSERTED SOME' => 'تم إضافة بعض الأعضاء بنجاح',
  'FAILED SOME' => 'فشل إضافة بعض الأعضاء بنجاح',
  'UPDATED' => 'تم تعديل بيانات العضو بنجاح',
  'NO CHANGES' => 'لا توجد تغييرات للحفظ',
  'NAME EMPTY' => 'إسم العضو فارغ',
  'JOB EMPTY' => 'وظيفة العضو فارغة',
  'DELETED' => 'تم حذف العضو بنجاح',

  // buttons words
  'ADD NEW' => 'إضافة عضو جديد',
  'EDIT TEAM' => 'تعديل العضو',
  'DELETE TEAM' => 'حذف العضو',
  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}