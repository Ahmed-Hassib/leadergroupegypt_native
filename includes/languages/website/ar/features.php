<?php

/**
 * function of words in arabic
 */
function features($phrase)
{
  static $lang = array(
  // words
  'FEATURE' => 'ميزة',
  'THE FEATURE' => 'الميزة',
  'FEATURES' => 'المميزات',
  'AR FEATURE NAME' => 'إسم الميزة باللغة العربية',
  'EN FEATURE NAME' => 'إسم الميزة باللغة الإنجليزية',
  'AR DETAIL NAME' => 'إسم النقطة باللغة العربية',
  'EN DETAIL NAME' => 'إسم النقطة باللغة الإنجليزية',
  'AR DESC FEATURE' => 'وصف الميزة باللغة العربية',
  'AR TEXT FEATURE' => 'شرح النقطة باللغة العربية',
  'EN DESC FEATURE' => 'وصف الميزة باللغة الإنجليزية',
  'EN TEXT FEATURE' => 'شرح النقطة باللغة الإنجليزية',
  'FEATURE IMG' => 'صورة الميزة',
  'STATUS' => 'حالة الميزة',
  'FEATURE INFO' => 'بيانات الميزة',
  'SELECT STATUS' => 'إختر حالة الميزة',
  'FEATURE DETAILS' => 'تفاصيل الميزة',

  // large statements
  'FEATURE DESC NOTE' => 'هذا الوصف يظهر في الموقع',

  // messages
  'SOME EMPTY' => 'يوجد بعض الحقول الفارغة برجاء التأكد من ملئها',
  'INSERTED' => 'تم إضافة جميع تفاصيل الميزة بنجاح',
  'INSERTED SOME' => 'تم إضافة بعض تفاصيل الميزة بنجاح',
  'FAILED' => 'حدث خطأ أثناء إضافة جميع الميزات',
  'FAILED SOME' => 'حدث خطأ أثناء إضافة بعض الميزات',
  'UPDATED' => 'تم تعديل الميزة بنجاح',
  'DELETED' => 'تم حذف الميزة بنجاح',
  'ACTIVATED' => 'تم تفعيل الميزة بنجاح',
  'DEACTIVATED' => 'تم إلغاء تفعيل الميزة بنجاح',
  'AR NAME FEATURE EMPTY' => 'إسم الميزة باللغة العربية فارغ',
  'EN NAME FEATURE EMPTY' => 'إسم الميزة باللغة الإنجليزية فارغ',
  'AR DESC FEATURE EMPTY' => 'وصف الميزة باللغة العربية فارغ',
  'AR TEXT FEATURE EMPTY' => 'شرح الميزة باللغة العربية فارغ',
  'EN DESC FEATURE EMPTY' => 'وصف الميزة باللغة الإنجليزية فارغ',
  'EN TEXT FEATURE EMPTY' => 'شرح الميزة باللغة الإنجليزية فارغ',
  'STATUS EMPTY' => 'حالة الميزة لم تُحدد',
  'FEATURE EMPTY' => 'لم يتم ادخال الميزة',
  'IMG EMPTY' => 'لم يتم تحديد صورة الميزة',

  // buttons words
  'ADD NEW' => 'إضافة ميزة جديد',
  'ADD DETAILS' => 'إضافة تفاصيل',
  'DELETE DETAILS' => 'حذف تفاصيل',
  );
  // return the phrase
  return $lang[$phrase];
}