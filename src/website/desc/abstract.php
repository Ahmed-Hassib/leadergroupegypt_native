<!-- START LANDING -->
<div class="landing">
  <div class="container">
    <div class="text">
      <h1>
        <span><?php echo lang('WELCOME TO', 'index') ?></span>
        <span class="badge bg-warning p-2"><?php echo lang('SERVICES') ?></span>
        <span><?php echo lang('SPONSOR') ?></span>
      </h1>
      <p>
        <span class="badge bg-primary"><?php echo lang('SYS TREE') ?></span>
        <span><?php echo '&nbsp;' . lang('SYSTREE DESC', $lang_file) ?></span>
      </p>
    </div>
    <!-- <div class="image">
            <img src="<?php echo $assets ?>systree.jpg" alt="Leader Group Egypt">
        </div> -->
  </div>
  <a href="#abstract" class="go-down">
    <i class="bi bi-chevron-double-down"></i>
  </a>
</div>
<!-- END LANDING -->

<div class="abstract" id="abstract">
  <h2 class="main-title"><?php echo lang('ABSTRACT', $lang_file) ?></h2>
  <div class="container">
    <div class="clearfix">
      <div class="col-sm-12 col-md-4 float-md-start mb-3 me-md-3">
        <img src="<?php echo $assets ?>leadergroupegypt.jpg" class="mb-2 w-100" alt="...">
        <!-- <img src="<?php echo $assets ?>leadergroupegypt.jpg" class="my-2 w-100" alt="..."> -->
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4"><?php echo lang('THE ESTABLISHMENT OF THE SYSTEM', $lang_file) ?></h4>
        </div>
        <div class="section-content">
          <p class="lead"><?php echo lang('THE ESTABLISHMENT OF THE SYSTEM DESCRIPTION', $lang_file) ?></p>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4"><?php echo lang('THE ADVANTAGE', $lang_file) ?></h4>
        </div>
        <div class="section-content">
          <ul>
            <li><?php echo lang('NETWORK DEVICES MANAGEMENT', $lang_file) ?></li>
            <li><?php echo lang('INVENTORY OF FAULTS', $lang_file) ?></li>
            <li><?php echo lang('COUNTING THE NEW CUSTOMERS', $lang_file) ?></li>
            <li><?php echo lang('FOLLOW UP ON EMPLOYEES ACTIVITY', $lang_file) ?></li>
            <li><?php echo lang('DRAW THE NETWORK IN THE FORM OF A BRANCHING TREE', $lang_file) ?></li>
          </ul>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4"><?php echo lang('CURRENT VERSION', $lang_file) ?></h4>
        </div>
        <div class="section-content">
          <p class="lead"><?php echo $curr_version ?></p>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4"><?php echo lang('DEVELOPMENT PROCESS', $lang_file) ?></h4>
        </div>
        <div class="section-content">
          <p class="lead"><?php echo lang('DEVELOPMENT PROCESS 1', $lang_file) ?></p>
        </div>
      </div>


      <div class="section">
        <div class="section-header">
          <h4 class="h4"><?php echo lang('HOW TO TAKE THE ADVANTAGE OF THE TRIAL VERSION', $lang_file) ?></h4>
        </div>
        <div class="section-content">
          <ul>
            <li>
              <p class="lead">
                <?php echo lang('VISIT SYSTEM LOGIN PAGE IF YOU ARE ALREADY A SUBSCRIBER', $lang_file) ?>
                <a style="text-decoration: underline;" href="<?php echo $sys_tree ?>login.php" target="_blank">
                  <?php echo lang('FROM HERE', $lang_file) ?>
                  <i style="font-size: 16px" class="bi bi-arrow-up-left-square"></i>
                </a>
              </p>
            </li>
            <li>
              <p class="lead">
                <?php echo lang('VISIT SYSTEM SIGNUP PAGE IF YOU ARE NOT A SUBSCRIBER', $lang_file) ?>&nbsp;
                <a style="text-decoration: underline;" href="<?php echo $sys_tree ?>signup.php" target="_blank"><?php echo lang('FROM HERE', $lang_file) ?>&nbsp;<i style="font-size: 16px" class="bi bi-arrow-up-left-square"></i></a>
                <?php echo lang('THEN FOLOOW THESE STEPS', $lang_file) ?>
              </p>

              <ul>
                <li>
                  <?php echo lang('ADD COMPANY NAME TAKING INTO ACCOUNT', $lang_file) ?>
                  <!-- warnig messages -->
                  <span class="badge bg-danger"><?php echo lang('DON`T WRITE ANY SPECIAL CHARACHTERS', $lang_file) ?></span>
                  <span class="badge bg-danger"><?php echo lang('DON`T WRITE ANY NUMBERS', $lang_file) ?></span>
                  <span class="badge bg-danger"><?php echo lang('DON`T WRITE ANY WHITE SPACES', $lang_file) ?></span>
                </li>
                <li><?php echo lang('ENTER THE MANAGER NAME', $lang_file) ?></li>
                <li><?php echo lang('ENTER MANAGER PHONE', $lang_file) ?></li>
                <li><?php echo lang('ENTER ADMIN FULL NAME', $lang_file) ?></li>
                <li><?php echo lang('CHOOSE ADMIN GENDER', $lang_file) ?></li>
                <li><?php echo lang('ENTER ADMIN USERNAME TO LOGIN', $lang_file) ?></li>
                <li><?php echo lang('ENTER ADMIN PASSWORD TAKING INTO ACCOUNT DON`T SHARE IT', $lang_file) ?></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4">
            <?php echo lang('HOW TO TAKE THE ADVANTAGE OF THE PAID VERSION', $lang_file) ?>
            <span class="badge bg-secondary"><?php echo lang('UNDER DEVELOPING', $lang_file) ?></span>
          </h4>
        </div>
        <div class="section-content">
        </div>
      </div>
    </div>
  </div>

  <div class="testimonials" id="testimonials">
    <h4 class="h4 main-title"><?php echo lang('CUSTOMER REVIEWS', $lang_file) ?></h4>
    <div class="container">
      <div class="box">
        <img src="<?php echo $website_assets ?>avatar-01.png" alt="">
        <h3>ahmed hassib</h3>
        <span class="title">frontend developer</span>
        <div class="rate">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star"></i>
        </div>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsum corrupti sequi dolorem odio cumque neque doloremque reprehenderit itaque quia temporibus accusamus</p>
      </div>
      <div class="box">
        <img src="<?php echo $website_assets ?>avatar-01.png" alt="">
        <h3>ahmed hassib</h3>
        <span class="title">frontend developer</span>
        <div class="rate">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star"></i>
        </div>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsum corrupti sequi dolorem odio cumque neque doloremque reprehenderit itaque quia temporibus accusamus</p>
      </div>
      <div class="box">
        <img src="<?php echo $website_assets ?>avatar-01.png" alt="">
        <h3>ahmed hassib</h3>
        <span class="title">frontend developer</span>
        <div class="rate">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star"></i>
        </div>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsum corrupti sequi dolorem odio cumque neque doloremque reprehenderit itaque quia temporibus accusamus</p>
      </div>
      <div class="box">
        <img src="<?php echo $website_assets ?>avatar-01.png" alt="">
        <h3>ahmed hassib</h3>
        <span class="title">frontend developer</span>
        <div class="rate">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star"></i>
        </div>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsum corrupti sequi dolorem odio cumque neque doloremque reprehenderit itaque quia temporibus accusamus</p>
      </div>
      <div class="box">
        <img src="<?php echo $website_assets ?>avatar-01.png" alt="">
        <h3>ahmed hassib</h3>
        <span class="title">frontend developer</span>
        <div class="rate">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star"></i>
        </div>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsum corrupti sequi dolorem odio cumque neque doloremque reprehenderit itaque quia temporibus accusamus</p>
      </div>
      <div class="box">
        <img src="<?php echo $website_assets ?>avatar-01.png" alt="">
        <h3>ahmed hassib</h3>
        <span class="title">frontend developer</span>
        <div class="rate">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star"></i>
        </div>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsum corrupti sequi dolorem odio cumque neque doloremque reprehenderit itaque quia temporibus accusamus</p>
      </div>
    </div>
  </div>
</div>