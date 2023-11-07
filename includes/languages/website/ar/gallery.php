<?php

/**
 * function of words in arabic
 */
function gallery($phrase)
{
  static $lang = array(
    // words
    'GALLERY'         => 'معرض الصور',
    'IMG INFO'        => 'بيانات الصورة',
    'IMG NAME'        => 'اسم الصورة',
    'STATUS'          => 'حالة الصورة',
    'SELECT STATUS'   => 'إختر حالة الصورة',
    'SETTINGS'        => 'إعدادات المعرض',
    '#DISPLAYED IMG'  => 'عدد صور العرض',

    // large words

    // messages
    'INSERTED'          => 'تم إضافة جميع الصور بنجاح',
    'INSERTED SOME'     => 'تم إضافة بعض الصور بنجاح',
    'FAILED SOME'       => 'توجد بعض الصور التي لم يتم إضافتها',
    'ACTIVATED'         => 'تم تفعيل الصورة بنجاح',
    'DEACTIVATED'       => 'تم إلغاء تفعيل الصورة بنجاح',
    'UPDATED'           => 'تم تعديل الصورة بنجاح',
    'DELETED'           => 'تم حذف الصورة بنجاح',
    'ID EMPTY'          => 'لا يمكن حفظ التغييرات بسبب وجود خطأ في البيانات',
    'NO CHANGES'        => 'لم يتم تغيير الصورة',
    'NUM ERROR'         => 'عدد الصور لا يمكن ان يكون فارغ',
    'UPDATED SETTINGS'  => 'تم تعديل إعدادات المعرض بنجاح',

    // buttons words
    'ADD NEW'       => 'إضافة صورة جديدة',
    'CHANGE IMG'    => 'تغيير الصورة',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
