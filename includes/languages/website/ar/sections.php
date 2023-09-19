<?php

/**
 * function of words in arabic
 */
function sections($phrase)
{
  static $lang = array(
    // words
    '#SEC'            => 'عدد الأقسام',
    'SECTION INFO'    => 'بيانات القسم',
    'CONTENT INFO'    => 'بيانات محتوى القسم',
    'AR TITLE'        => 'العنوان باللغة العربية',
    'EN TITLE'        => 'العنوان باللغة الانجليزية',
    'AR DESC'         => 'الوصف باللغة العربية',
    'EN DESC'         => 'الوصف باللغة الانجليزية',
    'AR CARD TITLE'   => 'عنوان المحتوى باللغة العربية',
    'EN CARD TITLE'   => 'عنوان المحتوى باللغة الانجليزية',
    'AR CARD DESC'    => 'وصف المحتوى باللغة العربية',
    'EN CARD DESC'    => 'وصف المحتوى باللغة الانجليزية',
    'SEC STATUS'      => 'حالة القسم',
    'HAVE LINK'       => 'يحتوى علي رابط',
    'STATUS'          => 'حالة المحتوى',

    // large statements

    // messages

    // buttons words
    'ADD NEW'         => 'إضافة قسم جديد',
    'ADD NEW CONTENT' => 'إضافة محتوى جديد',
    'EDIT SECTIONS'   => 'تعديل القسم',
    'DELETE SECTION'  => 'حذف القسم',
  );
  // return the phrase
  return $lang[$phrase];
}
