<?php $db_obj = isset($db_obj) ? $db_obj : new Database(); ?>
<div class="container page-container" dir="<?php echo $page_dir ?>">
  <div class="dashboard-content stats">
    <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
      <div class="card-body">
        <span class="icon-container <?php echo @$_SESSION['website']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-intersect"></i></span>
        <span class="d-block">
          <a href="<?php echo $nav_up_level ?>sections/index.php" class="stretched-link text-capitalize">
            <?php echo lang('SECTIONS', $lang_file) ?>
          </a>
        </span>
      </div>
    </div>
    <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
      <div class="card-body">
        <span class="icon-container <?php echo @$_SESSION['website']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-journal-text"></i></span>
        <span class="d-block">
          <a href="<?php echo $nav_up_level ?>about/index.php" class="stretched-link text-capitalize">
            <?php echo lang('ABOUT US', $lang_file) ?>
          </a>
        </span>
      </div>
    </div>
    <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
      <div class="card-body">
        <span class="icon-container <?php echo @$_SESSION['website']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-tools"></i></span>
        <span class="d-block">
          <a href="<?php echo $nav_up_level ?>services/index.php" class="stretched-link text-capitalize">
            <?php echo lang('THE SERVICES', $lang_file) ?>
          </a>
        </span>
      </div>
    </div>
    <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
      <div class="card-body">
        <span class="icon-container <?php echo @$_SESSION['website']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-image"></i></span>
        <span class="d-block">
          <a href="<?php echo $nav_up_level ?>gallery/index.php" class="stretched-link text-capitalize">
            <?php echo lang('GALLERY', $lang_file) ?>
          </a>
        </span>
      </div>
    </div>
    <div class="dashboard-card card card-stat <?php echo isset($card_class) ? $card_class : ''; ?> <?php echo isset($card_position) ? $card_position : ''; ?> bg-gradient">
      <div class="card-body">
        <span class="icon-container <?php echo @$_SESSION['website']['lang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>"><i class="bi bi-link-45deg"></i></span>
        <span class="d-block">
          <a href="<?php echo $nav_up_level ?>links/index.php" class="stretched-link text-capitalize">
            <?php echo lang('IMPORTANT LINKS', $lang_file) ?>
          </a>
        </span>
      </div>
    </div>
  </div>
</div>