<footer class="text-center">
  <!-- application name -->
  <div class="mt-1 row">
    <h3 class="fw-bold"><?php echo language('SYS TREE', @$_SESSION['systemLang']) ?></h3>
  </div>
  <!-- rate app or create a complaint or suggestion -->
  <div class="hstack gap-3" dir="<?php echo $_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
    <ul>
      <li>
        <!-- Button trigger modal -->
        <button type="button" data-bs-toggle="modal" data-bs-target="#ratingAppModal">
          <?php echo language('RATE APP', @$_SESSION['systemLang']) ?>
        </button>
      </li>
      <li>
        <a href="<?php echo $nav_up_level ?>comp-sugg/index.php">
          <?php echo language('COMPLAINTS & SUGGESTIONS', @$_SESSION['systemLang']) ?>
        </a>
      </li>
    </ul>
  </div>
  <!-- sponsor and developer name -->
  <div class="row fs-12">
    <p class="text-uppercase">
      <span><?php echo language('POWERED BY', @$_SESSION['systemLang']) ?></span>
      <span><?php echo $developerName . " &amp; " . $sponsorCompany ?></span>
      <span>&copy; 2023</span>
    </p>
  </div>
</footer>