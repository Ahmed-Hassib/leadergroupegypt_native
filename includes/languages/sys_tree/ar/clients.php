<?php

/**
 * function of words in arabic
 */
function clients($phrase)
{
  static $lang = array(
    // words
    'CLT'             => 'عميل',
    'LIST'            => 'قائمة العملاء',
    'CLT INFO'        => 'بيانات العميل',
    'CLT NAME'        => 'إسم العميل',
    'ADDR'            => 'عنوان العميل',
    'PHONE'           => 'تليفون العميل',
    'CLT STATISTICS'  => 'إحصائيات العملاء',
    'LATEST'          => 'أحدث العملاء المضافين',
    'DELETE CLT'      => 'حذف عميل',
    'PCS CLT INFO'    => 'بيانات جهاز العميل',
    'ALL CLTS'        => 'جميع العملاء',
    'CLT MALS'        => 'أعطال العميل',
    'DIR CLTS'        => 'عملاء إتجاه',
    '' => '',
    '' => '',

    // large words
    'CLT NOTE'    => 'يُعرض هنا بعض الأرقام والإحصائيات عن العملاء',
    'LATEST NOTE' => 'يُعرض هنا آخر 10 عملاء تم إضافتهم',


    // messages
    'INSERTED'    => 'تم إضافة بيانات العميل بنجاح',
    'UPDATED'     => 'تم تعديل بيانات العميل بنجاح',
    'DELETED'     => 'تم حذف بيانات العميل بنجاح',
    'NAME EXIST'  => 'إسم العميل موجود بالفعل',
    'IP EXIST'    => 'IP Address موجود بالفعل',
    'MAC EXIST'   => 'MAC Address موجود بالفعل',
    '' => '',

    // buttons words
    'ADD NEW' => 'إضافة عميل جديد',

  );
  // return the phrase
  return $lang[$phrase];
}
