<!-- START HEADER -->
<div class="header" id="header">
  <div class="container">
    <a href="<?php echo $up_level ?>index.php" class="logo text-uppercase"><?php echo language('LEADER GROUP') ?></a>
    <ul class="main-nav">
      <li><a href="<?php echo $up_level ?>index.php"><?php echo language('HOME') ?></a></li>
      <!-- <li>
        <a href="#blog-mega-menu"><?php echo language('OUR BLOG') ?></a>
        <div class="mega-menu">
          <div class="image">
            <img src="<?php echo $website_images ?>megamenu.png" alt="">
          </div>
          <ul class="links">
            <li>
              <a href="<?php echo $blog_user ?>index.php">
                <i class="bi bi-journals"></i>&nbsp;
                <?php echo language('THE BLOG') ?>
              </a>
            </li>
            <li>
              <a href="<?php echo $blog_user ?>index.php?do=show-topics">
                <i class="bi bi-images"></i>&nbsp;
                <?php echo language('THE TOPICS') ?>
              </a>
            </li>
          </ul>
          <ul class="links">
            <li>
              <a href="<?php echo $blog ?>login.php">
                <i class="bi bi-tools"></i>&nbsp;
                <span><?php echo language('BLOG LOGIN') ?></span>
              </a>
            </li>
            <li>
              <a href="<?php echo $blog ?>signup.php">
                <i class="bi bi-people"></i>&nbsp;
                <span><?php echo language('BLOG SIGNUP') ?></span>
              </a>
            </li>
          </ul>
        </div>
      </li> -->
      <li>
        <a href="#mega-menu"><?php echo language('OTHER') ?></a>
        <!-- START MEGA MENU -->
        <div class="mega-menu">
          <div class="image">
            <img src="<?php echo $website_images ?>megamenu.png" alt="">
          </div>
          <!-- <ul class="links">
            <li>
              <a href="<?php echo $up_level ?>index.php#articles">
                <i class="bi bi-journals"></i>&nbsp;
                <?php echo language('RECENT ARTICLES') ?>
              </a>
            </li>
            <li>
              <a href="<?php echo $up_level ?>index.php#gallery">
                <i class="bi bi-images"></i>&nbsp;
                <?php echo language('GALLERY') ?>
              </a>
            </li>
            <li>
              <a href="<?php echo $up_level ?>index.php#features">
                <i class="bi bi-pie-chart"></i>&nbsp;
                <?php echo language('FEATURES') ?>
              </a>
            </li>
          </ul> -->
          <ul class="links">
            <li>
              <a href="<?php echo $up_level ?>index.php#services">
                <i class="bi bi-tools"></i>&nbsp;
                <span><?php echo language('OUR SERVICES') ?></span>
              </a>
            </li>
            <!-- <li>
              <a href="<?php echo $up_level ?>index.php#team-members">
                <i class="bi bi-people"></i>&nbsp;
                <span><?php echo language('TEAM MEMBERS') ?></span>
              </a>
            </li> -->
            <li>
              <a href="<?php echo $up_level ?>index.php#testimonials">
                <i class="bi bi-chat"></i>&nbsp;
                <span><?php echo language('TESTIMONIALS') ?></span>
              </a>
            </li>
          </ul>
        </div>
        <!-- END MEGA MENU -->
      </li>
      <?php if (!isset($_SESSION['web_user_id'])) { ?>
        <!-- <li>
          <a href="<?php echo $website_src ?>pages/login.php">
            <?php echo language('LOGIN') ?>
          </a>
        </li>
        <li>
          <a href="<?php echo $website_src ?>pages/signup.php">
            <?php echo language('SIGNUP') ?>
          </a>
        </li> -->
      <?php } ?>
    </ul>
  </div>
</div>
<!-- END HEADER -->