<!-- START HEADER -->
<div class="header" id="header">
    <div class="container">
        <a href="<?php echo $blog_user ?>index.php" class="logo text-uppercase"><?php echo language('LEADER GROUP') ?></a>
        <ul class="main-nav">
            <li><a href="<?php echo $up_level ?>index.php"><?php echo language('WEBSITE') ?></a></li>
            <li>
                <a href="#blog-mega-menu"><?php echo language('OUR BLOG') ?></a>
                <!-- START MEGA MENU -->
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
                            <a href="<?php echo $blog_user ?>index.php?do=show-categories">
                                <i class="bi bi-images"></i>&nbsp;
                                <?php echo language('THE CATEGORIES') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $blog_user ?>index.php?do=show-topics">
                                <i class="bi bi-images"></i>&nbsp;
                                <?php echo language('THE TOPICS') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $blog_user ?>index.php?do=show-articles">
                                <i class="bi bi-images"></i>&nbsp;
                                <?php echo language('ARTICLES') ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- END MEGA MENU -->
            </li>
            
            <?php if (!isset($_SESSION['blog_user_id'])) { ?>
                <li>
                    <a href="<?php echo $blog ?>login.php">
                        <?php echo language('LOGIN') ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $blog ?>signup.php">
                        <?php echo language('SIGNUP') ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!-- END HEADER -->