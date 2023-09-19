<footer class="text-center">
  <!-- application name -->
  <div class="mt-1 row">
    <h3 class="fw-bold"><?php echo lang('SYS TREE') ?></h3>
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
      <span><?php echo lang('POWERED BY') ?></span>
      <span><?php echo $developerName . " &amp; " . $sponsorCompany ?></span>
      <span>&copy; 2023</span>
    </p>
  </div>
</footer>