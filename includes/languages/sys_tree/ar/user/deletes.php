<?php

/**
 * function of words in arabic
 */
function deletes($phrase)
{
  static $lang = array(
  // words
  'TRASH' => 'سلة المهملات',
  'DELETED CLIENTS' => 'العملاء المحذوفة',
  'RESTORE CLIENTS' => 'استرجاع العملاء',
  'DELETED PIECES' => 'الأجهزة المحذوفة',
  'RESTORE PIECES' => 'استرجاع الأجهزة',


  // large words


  // messages
  'CLIENT RESTORED' => 'تم استرجاع بيانات العميل بنجاح',
  'PIECE RESTORED' => 'تم استرجاع بيانات الجهاز بنجاح',
  'UPDATED' => 'تم تعديل بيانات  بنجاح',
  'DELETED' => 'تم حذف بيانات  بنجاح',

  // buttons words
  'ADD NEW' => 'إضافة طريقة الدفع',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
