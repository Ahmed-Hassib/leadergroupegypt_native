<div class="abstract" id="abstract">
  <h2 class="main-title"><?php echo language('ABSTRACT') ?></h2>
  <div class="container">
    <div class="clearfix">
      <div class="col-sm-12 col-md-4 float-md-start mb-3 me-md-3">
        <img src="<?php echo $assets ?>leadergroupegypt.jpg" class="mb-2 w-100" alt="...">
        <!-- <img src="<?php echo $assets ?>leadergroupegypt.jpg" class="my-2 w-100" alt="..."> -->
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4"><?php echo language('THE ESTABLISHMENT OF THE SYSTEM', @$_SESSION['systemLang']) ?></h4>
        </div>
        <div class="section-content">
          <p class="lead"><?php echo language('THE ESTABLISHMENT OF THE SYSTEM DESCRIPTION', @$_SESSION['systemLang']) ?></p>
        </div>
      </div>
      
      <div class="section">
        <div class="section-header">
          <h4 class="h4"><?php echo language('THE ADVANTAGE', @$_SESSION['systemLang']) ?></h4>
        </div>
        <div class="section-content">
          <ul>
            <li><?php echo language('NETWORK DEVICES MANAGEMENT', @$_SESSION['systemLang']) ?></li>
            <li><?php echo language('INVENTORY OF FAULTS', @$_SESSION['systemLang']) ?></li>
            <li><?php echo language('COUNTING THE NEW CUSTOMERS', @$_SESSION['systemLang']) ?></li>
            <li><?php echo language('FOLLOW UP ON EMPLOYEES ACTIVITY', @$_SESSION['systemLang']) ?></li>
            <li><?php echo language('DRAW THE NETWORK IN THE FORM OF A BRANCHING TREE', @$_SESSION['systemLang']) ?></li>
          </ul>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4"><?php echo language('CURRENT VERSION', @$_SESSION['systemLang']) ?></h4>
        </div>
        <div class="section-content">
          <p class="lead"><?php echo $curr_version ?></p>
        </div>
      </div>

      <div class="section">
        <div class="section-header">
          <h4 class="h4"><?php echo language('DEVELOPMENT PROCESS', @$_SESSION['systemLang']) ?></h4>
        </div>
        <div class="section-content">
          <p class="lead"><?php echo language('DEVELOPMENT PROCESS 1', @$_SESSION['systemLang']) ?></p>
        </div>
      </div>

      
      <div class="section">
        <div class="section-header">
          <h4 class="h4"><?php echo language('HOW TO TAKE THE ADVANTAGE OF THE TRIAL VERSION', @$_SESSION['systemLang']) ?></h4>
        </div>
        <div class="section-content">
          <ul>
            <li>
              <p class="lead">
                <?php echo language('VISIT SYSTEM LOGIN PAGE IF YOU ARE ALREADY A SUBSCRIBER', @$_SESSION['systemLang']) ?>
                <a style="text-decoration: underline;" href="<?php echo $sys_tree ?>login.php" target="_blank">
                  <?php echo language('FROM HERE', @$_SESSION['systemLang']) ?>
                  <i style="font-size: 16px" class="bi bi-arrow-up-left-square"></i>
                </a>
              </p>
            </li>
            <li>
              <p class="lead">
                <?php echo language('VISIT SYSTEM SIGNUP PAGE IF YOU ARE NOT A SUBSCRIBER', @$_SESSION['systemLang']) ?>&nbsp;
                <a style="text-decoration: underline;" href="<?php echo $sys_tree ?>signup.php" target="_blank"><?php echo language('FROM HERE', @$_SESSION['systemLang']) ?>&nbsp;<i style="font-size: 16px" class="bi bi-arrow-up-left-square"></i></a>
                <?php echo language('THEN FOLOOW THESE STEPS', @$_SESSION['systemLang']) ?>
              </p>
              
              <ul>
                <li>
                  <?php echo language('ADD COMPANY NAME TAKING INTO ACCOUNT', @$_SESSION['systemLang']) ?>
                  <!-- warnig messages -->
                  <span class="badge bg-danger"><?php echo language('DON`T WRITE ANY SPECIAL CHARACHTERS', @$_SESSION['systemLang']) ?></span>
                  <span class="badge bg-danger"><?php echo language('DON`T WRITE ANY NUMBERS', @$_SESSION['systemLang']) ?></span>
                  <span class="badge bg-danger"><?php echo language('DON`T WRITE ANY WHITE SPACES', @$_SESSION['systemLang']) ?></span>
                </li>
                <li><?php echo language('ENTER THE MANAGER NAME', @$_SESSION['systemLang']) ?></li>
                <li><?php echo language('ENTER MANAGER PHONE', @$_SESSION['systemLang']) ?></li>
                <li><?php echo language('ENTER ADMIN FULL NAME', @$_SESSION['systemLang']) ?></li>
                <li><?php echo language('CHOOSE ADMIN GENDER', @$_SESSION['systemLang']) ?></li>
                <li><?php echo language('ENTER ADMIN USERNAME TO LOGIN', @$_SESSION['systemLang']) ?></li>
                <li><?php echo language('ENTER ADMIN PASSWORD TAKING INTO ACCOUNT DON`T SHARE IT', @$_SESSION['systemLang']) ?></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      
      <div class="section">
        <div class="section-header">
          <h4 class="h4">
            <?php echo language('HOW TO TAKE THE ADVANTAGE OF THE PAID VERSION', @$_SESSION['systemLang']) ?>
            <span class="badge bg-secondary"><?php echo language('UNDER DEVELOPING', @$_SESSION['systemLang']) ?></span>
          </h4>
        </div>
        <div class="section-content">
        </div>
      </div>
    </div>
  </div>

  <div class="testimonials" id="testimonials">
    <h4 class="h4 main-title"><?php echo language('CUSTOMER REVIEWS', @$_SESSION['systemLang']) ?></h4>
    <div class="container">
      <div class="box">
        <img src="<?php echo $website_images?>avatar-01.png" alt="">
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
        <img src="<?php echo $website_images?>avatar-01.png" alt="">
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
        <img src="<?php echo $website_images?>avatar-01.png" alt="">
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
        <img src="<?php echo $website_images?>avatar-01.png" alt="">
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
        <img src="<?php echo $website_images?>avatar-01.png" alt="">
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
        <img src="<?php echo $website_images?>avatar-01.png" alt="">
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