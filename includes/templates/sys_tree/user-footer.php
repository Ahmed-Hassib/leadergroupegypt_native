<footer class="text-center">
  <!-- application name -->
  <div class="mt-1 row">
    <?php $footer_img_name = "systree.png"; ?>
    <?php $footer_img_path = $systree_assets . "systree.png"; ?>
    <?php $footer_resized_img_path = $systree_assets . "resized/systree.png"; ?>
    <?php if (file_exists($footer_img_path)) { ?>
      <div class="footer-image">
        <?php $is_resized = resize_img($systree_assets, $footer_img_name); ?>
        <!-- <?php $is_resized = false; ?> -->
        <img src="<?php echo $is_resized ? $footer_resized_img_path : $footer_img_path ?>" alt="Systree app ">
      </div>
    <?php } else { ?>
      <h3 class="fw-bold">
        <?php echo lang('SYS TREE') ?>
      </h3>
    <?php } ?>
  </div>
  <!-- rate app or create a complaint or suggestion -->
  <div class="hstack gap-3" dir="<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <ul>
      <li>
        <!-- Button trigger modal -->
        <button type="button" data-bs-toggle="modal" data-bs-target="#ratingAppModal">
          <?php echo lang('RATE APP') ?>
        </button>
      </li>
      <!-- <li>
        <a href="<?php echo $nav_up_level ?>comp-sugg/index.php">
          <?php echo lang('COMP & SUGG', 'sugg_comp') ?>
        </a>
      </li> -->
    </ul>
  </div>
  <!-- sponsor and developer name -->
  <div class="row fs-12">
    <p class="text-uppercase">
      <span>
        <?php echo lang('POWERED BY') ?>
      </span>
      <span>
        <?php echo $developerName . " &amp; " . $sponsorCompany ?>
      </span>
      <span>&copy; 2023</span>
    </p>
  </div>
</footer>