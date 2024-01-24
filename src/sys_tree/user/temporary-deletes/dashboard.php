<?php
// check system theme
if ($_SESSION['sys']['system_theme'] == 2) {
  $card_class = 'card-effect';
  $card_position = $_SESSION['sys']['lang'] == "ar" ? "card-effect-right" : "card-effect-left";
}
?>
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="stats">
    <div class="dashboard-content">
      <div class="dashboard-card card card-stat <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
        <div class="card-body">
          <span
            class="icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?> bg-primary"><i
              class="bi bi-person-x"></i></span>
          <h5 class="h5 text-capitalize">
            <?php echo lang('DELETED CLIENTS', $lang_file) ?>
          </h5>
        </div>
        <a href="?do=clients" class="stretched-link text-capitalize"></a>
      </div>
      <div
        class="dashboard-card card card-stat  <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
        <div class="card-body">
          <span
            class="icon-container <?php echo @$_SESSION['sys']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?> bg-primary"><i
              class="bi bi-hdd-rack"></i></span>
          <h5 class="h5 text-capitalize">
            <?php echo lang('DELETED PIECES', $lang_file) ?>
          </h5>
        </div>
        <a href="?do=pieces" class="stretched-link text-capitalize"></a>
      </div>
    </div>
  </div>
</div>