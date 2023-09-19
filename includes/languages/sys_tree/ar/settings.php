<?php

/**
 * function of words in arabic
 */
function settings($phrase)
{
  static $lang = array(
    // words
    'COMPANY BRAND'   => 'شعار الشركة',
    'CHANGE IMG'      => 'تغيير الصورة',
    'OTHER'           => 'أخرى',
    'PING COUNTER'    => 'عدد رسائل Ping',
    'SYSTEM INFO'     => 'بيانات النظام',
    'FOREVER'         => 'مدى الحياة',
    'MONTHLY'         => 'شهرى',
    '3 MONTH'         => '3 أشهر',
    '6 MONTH'         => '6 أشهر',
    'YEARLY'          => 'سنوى',
    'TRIAL'           => 'نسخة تجريبية',
    'COMPANY NAME'    => 'إسم الشركة',
    'COMPANY CODE'    => 'كود الشركة',
    'APP VERSION'     => 'إصدار البرنامج',
    'LICENSE'         => 'نوع الترخيص',
    'EXPIRY'          => 'تاريخ الإنتهاء',
    'SYSTEM LANG'     => 'لغة النظام',
    'MIKROTIK INFO'   => 'بيانات ميكروتك',
    '' => '',

    // large words
    'DEFAULT IMG' => 'هذة الصورة الإفتراضية للنظام',
    
    // messages
    'IMG UPDATED'       => 'تم تغيير صورة الشركة بنجاح',
    'SETTINGS UPDATED'  => 'تم حفظ الإعدادات بنجاح',
    'IP EMPTY'          => 'عنوان IP فارغ',
    'PORT EMPTY'        => 'Port فارغ',
    'USERNAME EMPTY'    => 'إسم المستخدم فارغ',
    'PASSWORD EMPTY'    => 'الرقم السري فارغ',
    'MIKROTIK UPDATED'  => 'تم تعديل بيانات ميكروتيك بنجاح',

  );
  // return the phrase
  return $lang[$phrase];
}
