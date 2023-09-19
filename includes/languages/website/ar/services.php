<?php

/**
 * function of words in arabic
 */
function services($phrase)
{
  static $lang = array(
    // words
    'SERVICE INFO'  => 'بيانات الخدمة',
    'SERVICE IMG'   => 'صورة الخدمة',
    'LINK 1 AR'     => 'الرابط الأول باللغة العربية',
    'LINK 1 EN'     => 'الرابط الأول باللغة الانجليزية',
    'LINK 1'        => 'الرابط الأول',
    'LINK 2 AR'     => 'الرابط الثانى باللغة العربية',
    'LINK 2 EN'     => 'الرابط الثانى باللغة الإنجليزية',
    'LINK 2'        => 'الرابط الثانى',
    'STATUS'        => 'حالة الخدمة',
    'SELECT STATUS' => 'إختر حالة الخدمة',
    'CHANGE IMG'    => 'تغيير الصورة',
    
    
    // large statements
    
    // messages
    'INSERTED'        => 'تم إضافة جميع الخدمات بنجاح',
    'UPDATED'         => 'تم تعديل الخدمة بنجاح',
    'DELETED'         => 'تم حذف الخدمة بنجاح',
    'INSERTED SOME'   => 'تم إضافة بعض الخدمات بنجاح',
    'FAILED'          => 'حدث خطأ أثناء إضافة جميع الخدمات',
    'FAILED SOME'     => 'حدث خطأ أثناء إضافة بعض الخدمات',
    'ACTIVATED'       => 'تم تفعيل الخدمة بنجاح',
    'DEACTIVATED'     => 'تم إلغاء تفعيل الخدمة بنجاح',
    'WAITING'         => 'تم تغيير حالة الخدمة الي الإنتظار',
    
    // buttons words
    'ADD NEW' => 'إضافة خدمة جديدة',


  );
  // return the phrase
  return $lang[$phrase];
}
