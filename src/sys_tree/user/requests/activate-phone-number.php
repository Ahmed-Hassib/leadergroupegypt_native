<?php
require_once($vendor . 'ultramsg/whatsapp-php-sdk/ultramsg.class.php');
// mobile phone
$phone_number = '+2'.$_SESSION['phone'];
// $phone_number = '+201028680375';
// activation code
$activation_code = random_digits(4);
// message body
$msg_body  = language('HI', @$_SESSION['systemLang']) . ' ' . $_SESSION['UserName'] . ' ';
$msg_body .= language('SYS TREE APP TEAM GREATE YOU', @$_SESSION['systemLang']) . '. ';
$msg_body .= language('YOUR ACTIVATION CODE IS', @$_SESSION['systemLang']) . ' ';
$msg_body .= " _*$activation_code*_, ";
$msg_body .= language('DON`T SHARE THE ACTIVATION CODE WITH ANY ONE ELSE', @$_SESSION['systemLang']) . ' ';
$msg_body .= language('THUS', @$_SESSION['systemLang']) . ' ';
$msg_body .= language('YOUR ACTIVATION CODE WILL EXPIRE WITHIN 1 MINUTE', @$_SESSION['systemLang']) . ' ';

// $msg_body .= language('THE SYS TREE APP TEAM INFORMS YOU THAT THEY ARE WORKING ON A NEW ALGORITHM TO CONFIRM THE PHONE NUMBER, THIS IS A RECORDED MESAGE AND YOU WILL BE NOTIFIED BY THE APPLICATION WHEN IT IS COMPLETED. WE WISH YOU CONTINUED SUCCESS', @$_SESSION['systemLang']);

// api info
$ultramsg_token = "xgkn9ejfc8b9ti1a"; // Ultramsg.com token
$instance_id = "instance46427"; // Ultramsg.com instance id
$client = new UltraMsg\WhatsAppApi($ultramsg_token, $instance_id);

// phone number
$to = $phone_number;

// send message
$api_response = $client->sendChatMessage($to, $msg_body);

// print api response
print_r($api_response);

// echo $phone_number;

?>