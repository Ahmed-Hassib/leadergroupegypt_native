<?php
// check if Get request userid is numeric and get the integer value
$dir_id = isset($_GET['dir-id']) && is_numeric($_GET['dir-id']) ? intval($_GET['dir-id']) : 0;
// 
$dir_name = selectSpecificColumn("`direction_name`", "`direction`", "WHERE `direction_id` = $dir_id")[0]['direction_name'];
// query select
$q = "SELECT `pieces_info`.`id`, `pieces_info`.`ip`, `pieces_info`.`full_name`, `pieces_info`.`source_id`, `direction`.`direction_name`, `direction`.`direction_id` FROM `pieces_info` LEFT JOIN `direction` ON `direction`.`direction_id` = `pieces_info`.`direction_id` WHERE `pieces_info`.`direction_id` = ? AND `pieces_info`.`is_client` = 0 AND `pieces_info`.`company_id` = ?";

$stmt = $con->prepare($q);          // select all users
$stmt->execute(array($dir_id, $_SESSION['company_id']));      // execute data
$rows = $stmt->fetchAll();          // assign all data to variable
$dataCount = $stmt->rowCount();     // count the row data

$sub_data = [];
$data = [];
// loop on result ..
foreach ($rows as $row) {
  // get all information of pieces_info..
  $data[$row["id"]]["id"]             = $row["id"];
  $data[$row["id"]]["ip"]             = $row["ip"];
  $data[$row["id"]]["full_name"]      = $row["full_name"];
  $data[$row["id"]]["source_id"]      = $row["source_id"];
  $data[$row["id"]]["direction_name"] = $row["direction_name"];
  $data[$row["id"]]["direction_id"]   = $row["direction_id"];
  // $data[] = $row;
}
?>
<!-- start add new user page -->
<div class="container" name="showDir" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <!-- start header -->
  <header class="header">
    <h3 class="h3 text-primary"><?php echo $dir_name ?></h3>
  </header>
  <!-- end header -->
</div>
<?php if (count($data) > 0) { ?>

  <!-- start showing directions tree -->
  <div class="genealogy-body genealogy-scroll">
    <div class="genealogy-tree text-center">
      <?php build_direction_tree($data, 0); ?>
    </div>
    
    <div class="fixed-scroll-btn">
      <!-- scroll left button -->
      <button type="button" role="button" class="scroll-button scroll-prev scroll-prev-right">
        <i class="carousel-control-prev-icon"></i>
      </button>
      <!-- scroll right button -->
      <button type="button" role="button" class="scroll-button scroll-next <?php echo $_SESSION['systemLang'] == 'ar' ? 'scroll-next-left' : 'scroll-next-right' ?>">
        <i class="carousel-control-next-icon"></i>
      </button>
    </div>
  </div>
  <!-- end showing directions tree -->
<?php } else {
  include_once $globmod . 'no-data-founded-no-redirect.php';
} ?>