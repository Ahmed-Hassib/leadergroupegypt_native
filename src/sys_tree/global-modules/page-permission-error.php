<?php
// prepare flash session variables
$_SESSION['flash_message'][0] = 'NO PAGE WITH THIS NAME';
$_SESSION['flash_message_icon'][0] = 'bi-exclamation-triangle-fill';
$_SESSION['flash_message_class'][0] = 'danger';
$_SESSION['flash_message_status'][0] = false;
// prepare flash session variables
$_SESSION['flash_message'][1] = 'YOU DON`T HAVE THE PERMISSION TO ACCESS THIS PAGE';
$_SESSION['flash_message_icon'][1] = 'bi-exclamation-triangle-fill';
$_SESSION['flash_message_class'][1] = 'danger';
$_SESSION['flash_message_status'][1] = false;
// redirect to the previous page
redirect_home(null, 'back', 0);