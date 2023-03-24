<?php
// no footer
$noFooter = true;
// check if Get request userid is numeric and get the integer value
$dirid = isset($_GET['dirId']) && is_numeric($_GET['dirId']) ? intval($_GET['dirId']) : 0;
// 
$dirname = selectSpecificColumn("`direction_name`", "`direction`", "WHERE `direction_id` = ".$dirid)[0]['direction_name'];
// query select
$q = "SELECT `pieces`.`piece_id`, `pieces`.`piece_ip`, `pieces`.`piece_name`, `pieces`.`source_id`, `pieces`.`type_id`, `direction`.`direction_name`, `direction`.`direction_id` FROM `pieces` LEFT JOIN `direction` ON `direction`.`direction_id` = `pieces`.`direction_id` WHERE `pieces`.`direction_id` = ? AND `pieces`.`is_client` = 0 AND `pieces`.`company_id` = ?";

$stmt = $con->prepare($q);          // select all users
$stmt->execute(array($dirid, $_SESSION['company_id']));      // execute data
$rows = $stmt->fetchAll();          // assign all data to variable
$dataCount = $stmt->rowCount();     // count the row data

$sub_data = [];
$data = [];
// loop on result ..
foreach ($rows as $row) {
    // get all information of pieces..
    $data[$row["piece_id"]]["piece_id"]         = $row["piece_id"];
    $data[$row["piece_id"]]["piece_ip"]         = $row["piece_ip"];
    $data[$row["piece_id"]]["piece_name"]       = $row["piece_name"];
    $data[$row["piece_id"]]["source_id"]        = $row["source_id"];
    $data[$row["piece_id"]]["type_id"]          = $row["type_id"];
    $data[$row["piece_id"]]["direction_name"]   = $row["direction_name"];
    $data[$row["piece_id"]]["direction_id"]     = $row["direction_id"];
    // $data[] = $row;
}
?>
<!-- start add new user page -->
<div class="container" name="showDir" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <!-- start header -->
    <header class="header">
        <h3 class="h3 text-primary"><?php echo $dirname ?></h3>
    </header>
    <!-- end header -->
    <!-- start showing directions pieces -->
</div>
<div class="genealogy-body genealogy-scroll">
    <div class="genealogy-tree text-center">
        <?php
            if (count($data) > 0) {
                // buildTreeview($sub_data, 0);
                buildTreeview($data, 0);
            } else { ?>
                <h5 class="h5 text-danger  text-capitalize"><?php echo language('THERE IS NO PIECES TO SHOW', @$_SESSION['systemLang']) ?></h5>
        <?php } ?>
    </div>
</div>
<!-- end showing directions pieces -->