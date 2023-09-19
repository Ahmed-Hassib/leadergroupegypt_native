<?php

/**
 * function of words in arabic
 */
function global_($phrase)
{
  static $lang = array(
    // global words
    'AR'                => 'اللغة العربية',
    'EN'                => 'اللغة الانجليزية',
    'LANG'              => 'اللغة',
    'YES'               => 'نعم',
    'NO'                => 'لا',
    'LINK'              => 'الرابط',
    'LOGIN'             => 'تسجيل الدخول',
    'LOGOUT'            => 'تسجيل خروج',
    'SIGNUP'            => 'تسجيل جديد',
    'USERNAME'          => 'اسم المستخدم',
    'PASSWORD'          => 'الرقم السرى',
    'COMPANY CODE'      => 'كود الشركة',
    'UNDER DEVELOPING'  => 'تحت التطوير',
    'SPONSOR'           => 'LEADER GROUP EGYPT',
    'SYS TREE'          => 'SYS TREE',
    'SYS TREE DESC'     => 'شرح السيستم',
    'TRIAL'             => 'نسخة تجريبية',
    'REFRESH SESSION'   => 'تحديث الجلسة',
    'REFRESH PAGE'      => 'إعادة تحميل الصفحة',
    'NEW'               => 'جديد',
    'RATE APP'          => 'تقييم التطبيق',
    'POWERED BY'        => 'powered by',
    'PROFILE'           => 'الصفحة الشخصية',
    'JOINED'            => 'انضم في',
    'COMPANY IMG'       => 'شعار الشركة',
    'READ MORE'         => 'قراءة المزيد',
    'DETAILS'           => 'التفاصيل',
    'UNKNOWN'           => 'غير معروف',
    'ADDED BY'          => 'أضيفت بواسطة',
    'ADDED DATE'        => 'تاريخ الإضافة',
    'ADDED TIME'        => 'وقت الإضافة',
    'SHOWED DATE'       => 'تاريخ الرؤية',
    'SHOWED TIME'       => 'وقت الرؤية',
    'FINISHED DATE'     => 'تاريخ الإنتهاء',
    'FINISHED TIME'     => 'وقت الإنتهاء',
    'DELAYED DATE'      => 'تاريخ التأجيل',
    'DELAYED TIME'      => 'وقت التأجيل',
    'REVIEWED DATE'     => 'تاريخ التقييم',
    'REVIEWED TIME'     => 'وقت التقييم',
    'FINISHED PERIOD'   => 'زمن الإنتهاء',
    'BACK'              => 'عودة',
    'IP'                => 'IP Address',
    'MAC'               => 'MAC Address',
    'PORT'              => 'Port',
    'SECOND'            => 'ثانية',
    'SECONDS'           => 'ثوانى',
    'MINUTE'            => 'دقيقة',
    'MINUTES'           => 'دقائق',
    'HOUR'              => 'ساعة',
    'HOURS'             => 'ساعات',
    'DAY'               => 'يوم',
    'DAYS'              => 'أيام',
    'MONTH'             => 'شهر',
    'MONTHS'            => 'أشهر',
    'YEAR'              => 'سنة',
    'YEARS'             => 'سنوات',
    'L.E'               => 'جنية مصرى',
    'BAD'               => 'سئ',
    'GOOD'              => 'جيد',
    'VERY GOOD'         => 'جيد جداً',
    'RIGHT'             => 'صحيح',
    'WRONG'             => 'غير صحيح',
    'WAITING'           => 'في الإنتظار',
    'ACTIVE'            => 'مُفعّل',
    'INACTIVE'          => 'غير مُفعّل',
    'SHOW MORE'         => 'عرض المزيد',
    'ABOUT US'          => 'نبذة عن الشركة',
    
    
    // pages title
    'DASHBOARD'   => 'لوحة التحكم',
    
    // NAVBAR WORDS
    // website navbar
    'HOME'              => 'الصفحة الرئيسية',
    'OUR BLOG'          => 'منتدانا',
    'TOPICS'            => 'الموضوعات',
    'SERVICES'          => 'خدمات',
    'THE SERVICES'      => 'الخدمات',
    'OUR SERVICES'      => 'خدماتنا',
    'TEAM MEMBERS'      => 'اعضاء الفريق',
    'TESTIMONIALS'      => 'آراء العملاء',
    'OTHER'             => 'أخرى',
    'IMPORTANT LINKS'   => 'الروابط الهامة',
    'GALLERY'           => 'معرض الصور',
    'CONTACT US'        => 'تواصل معنا',

    
    // sys tree navbar
    'EMPLOYEES'         => 'الموظفين',
    'DIRECTIONS'        => 'الإتجاهات',
    'PIECES'            => 'الأجهزة',
    'CLIENTS'           => 'العملاء',
    'MALS'              => 'الأعطال',
    'COMBS'             => 'التركيبات',
    'CONNECTION TYPES'  => 'أنواع الإتصال',
    'COMBINATIONS'      => 'التركيبات',
    'SETTINGS'          => 'الإعدادات',
    
    
    // large global words
    'SYS UNDER DEVELOPING'  => 'نعتذر منكم! السيستم الآن تحت التطوير',
    'DON`T HAVE ACCOUNT'    => 'لا تمتلك حساب',
    '*REQUIRED'             => 'ملحوظة: تشير هذة العلامة * الي الحقول المطلوبة',
    '*TECH REQUIRED'        => 'لم يتم إضافة أى فنى لإضافة عطل/تركيبة جديدة',
    'HARD & COMPLEX'        => 'ألرقم السر يجب ان يكون صعب ومعقد',
    'CONFIRM DELETE'        => 'هل أنت متأكد من حذف',
    'PASS NOTE'             => 'لا تشارك الرقم السرى مع احد',
    'ENG NUM'               => 'يجب إدخال الأرقام باللغة الإنجليزية',
    'MEDIA FAILED'          => 'فشل تحميل الصورة/الفيديو',
    
    // global messages
    'NOT ASSIGNED'              => 'لم يُحدد',
    'NAME EXIST'                => 'هذا الإسم موجود بالفعل',
    'REDIRECT AUTO'             => 'سيتم اعادة تحويلك تلقائيا بعد',
    'ACCESS FAILED'             => 'لايمكن الدخول لهذة الصفحة',
    'NO DATA'                   => 'لا توجد بيانات للعرض',
    'QUERY PROBLEM'             => 'حدثت مشكلة اثناء حفظ البيانات',
    'LOGIN SUCCESS'             => 'تسجيل دخول ناجح',
    'LOGIN FAILED'              => 'تسجيل دخول خاطئ',
    'MISSING DATA'              => 'يوجد خطأ او فقد في بعض البيانات',
    'NO PAGE'                   => 'لا توجد صفحة بهذا الإسم',
    'LICENSE ENDED'             => 'لقد انتهت صلاحية السيستم لديك',
    'PERMISSION FAILED'         => 'لا توجد صلاحية للدخول لهذه الصفحة',
    'PERMISSION INSERT FAILED'  => 'لا توجد صلاحية الإضافة لديك',
    'PERMISSION UPDATE FAILED'  => 'لا توجد صلاحية التعديل لديك',
    'PERMISSION DELETE FAILED'  => 'لا توجد صلاحية الحذف لديك',
    'SESSION UPDATED'           => 'تم تحديث الجلسة بنجاح',
    'SESSION FAILED'            => 'حدثت مشكلة أثناء تحديث الجلسة',
    'NO CHANGES'                => 'لا يوجد تغييرات لكي يتم حفظها',
    'MIKROTIK SUCCESS'          => 'تم الاتصال ببيانات ميكروتيك الخاص بك بنجاح',
    'MIKROTIK FAILED'           => 'فشل الإتصال ببيانات ميكروتيك الخاص بك',
    'RATING SUCCESS'            => 'شكراً لكم! لقد قمت بتقييم السيستم بنجاح',
    'RATED FAILED'              => 'حدث خطأ أثناء إرسال تقييمكم برجاء المحاولة مرة أخرى',
    'RATED BEFORE'              => 'شكراً لكم! لقم قمت بتقييم السيستم من قبل',
    

    // tables words
    'NOTE'      => 'الملاحظات',
    'CONTROL'   => 'الاجراء',

    // buttons words
    'ADD'             => 'اضافة',
    'EDIT'            => 'تعديل',
    'DELETE'          => 'حذف',
    'SHOW'            => 'عرض',
    'RATING'          => 'تقييم',
    'SAVE'            => 'حفظ التغييرات',
    'CLOSE'           => 'اغلاق',
    'SEND'            => 'ارسال',
    'DELETE IMG'      => 'حذف الصورة',
    'CHANGE IMG'      => 'تغيير الصورة',
    'DELETE MEDIA'    => 'حذف الصور/الفيديوهات',
    'DOWNLOAD MEDIA'  => 'تحميل الصور/الفيديوهات',
    'SELECT LANG'     => 'إختر اللغة',

  );
  // return the phrase
  return $lang[$phrase];
}
