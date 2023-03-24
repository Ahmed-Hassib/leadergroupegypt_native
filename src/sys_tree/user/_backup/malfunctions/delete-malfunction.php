<?php
// create an object of Malfunction class
$mal_obj = new Malfunction();
// get malfunction id
$mal_id = isset($_GET['malid']) && intval($_GET['malid']) ? intval($_GET['malid']) : 0;
// check if the current malfunction id is exist or not
$is_exist = $mal_obj->is_exist("`mal_id`", "`malfunctions`", $mal_id);
?>
<?php if ($is_exist == true) { ?>
    <!-- start edit profile page -->
    <div class="container" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
        <!-- start header -->
        <header class="header">
            <?php
                // call delete function
                $mal_obj->delete_malfunction($mal_id);
                // show the successfull messgae
                $msg  = '<div class="alert alert-success text-capitalize"><i class="bi bi-check-circle-fill">'.language("MALFUNCTION WAS DELETED SUCCESSFULLY").'</div>';
                redirectHome($msg);
            ?>
        </header>
    </div>
<?php } else {
    // include no data founded
    include_once $globmod . 'no-data-founded.php';
}
?>