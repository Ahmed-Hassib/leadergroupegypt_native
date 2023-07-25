<?php
// prepare flash session variables
$_SESSION['flash_message'] = 'THERE IS AN ERROR OR MISSING DATA';
$_SESSION['flash_message_icon'] = 'bi-exclamation-triangle-fill';
$_SESSION['flash_message_class'] = 'danger';
$_SESSION['flash_message_status'] = false;
// redirect to the previous page
redirect_home(null, 'back', 0);