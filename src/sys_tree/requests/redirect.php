<?php 
$page_title = "new registration";
// level
$level = 3;
// nav level
$nav_level = 1;
// initial configration of system
include_once str_repeat("../", $level) . "etc/init.php";

print_r($_POST);
?>

<form action="<?php echo str_repeat("../", $nav_level) ?>login">
    <input type="text" name="">
</form>