<?php

/**
 * function of words in arabic
 */
function payment($phrase)
{
  static $lang = array(
  // words
  'PAYMENTS' => 'المدفوعات',
  'PRICING PLANS' => 'خطط الاسعار',
  'VODAFONE CASH' => 'vodafone cash',
  'TRANSACTIONS' => 'عمليات الدفع',

  // large words


  // messages
  'INSERTED' => 'تم إضافة بيانات  بنجاح',
  'UPDATED' => 'تم تعديل بيانات  بنجاح',
  'DELETED' => 'تم حذف بيانات  بنجاح',

  // buttons words
  'ADD NEW' => 'إضافة طريقة الدفع',

  );
  // return the phrase
  return array_key_exists($phrase, $lang) ? $lang[$phrase] : null;
}
