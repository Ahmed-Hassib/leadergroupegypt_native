<?php

echo base64_encode('root-login');
// redirect page
header("refresh:3;url=../login.php?rt=" . base64_encode('root-login'));
// exit
exit();