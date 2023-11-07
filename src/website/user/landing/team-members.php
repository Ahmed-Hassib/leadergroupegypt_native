<?php
// create an object of TeamMember class
$member_obj = new TeamMember();
// get section info
$members_info = $member_obj->select_specific_column("*", "`sections`", "WHERE `section_id` = '" . $member_obj->SECTION_ID . "'");
// get section status
$members_status = count($members_info) > 0 ? boolval($members_info[0]['is_active']) : false;
// get all members
$members_info = $member_obj->get_active_members();
// check length
if ($members_status && $members_info != null && count($members_info) > 0) {
  // get number of displayed content
  $num_displayed = intval($member_obj->select_specific_column("`num_content`", "`sections`", "WHERE `section_id` = '" . $member_obj->SECTION_ID . "' AND `section_name` = '" . $member_obj->SECTION_NAME . "'")[0]['num_content'] ?? 9);

  ?>
  <!-- START TEAM MEMBERS -->
  <div class="team-members <?php echo isset($members_status) && $members_status == null ? 'no-wave-all' : '' ?>"
    id="team-members">
    <h2 class="main-title">
      <?php echo lang('TEAM MEMBERS') ?>
    </h2>
    <div class="container">
      <?php foreach ($members_info as $key => $member) { ?>
        <div class="box">
          <div class="data">
            <?php if (!empty($member['img']) && file_exists($members_img . $member['img'])) { ?>
              <img loading="lazy" src="<?php echo $members_img . $member['img'] ?>" alt="">
            <?php } else { ?>
              <img loading="lazy" src="<?php echo $website_assets ?>team-01.jpg" alt="">
            <?php } ?>
            <div class="social">
              <?php if (!empty($member['facebook']) && facebook_validation($member['facebook'])) { ?>
                <a href="<?php echo $member['facebook'] ?>" target="_blank">
                  <i class="bi bi-facebook"></i>
                </a>
              <?php } ?>
              <?php if (!empty($member['instagram']) && instagram_validation($member['instagram'])) { ?>
                <a href="<?php echo $member['instagram'] ?>" target="_blank">
                  <i class="bi bi-instagram"></i>
                </a>
              <?php } ?>
              <?php if (!empty($member['twitter']) && twitter_validation($member['twitter'])) { ?>
                <a href="<?php echo $member['twitter'] ?>" target="_blank">
                  <i class="bi bi-twitter"></i>
                </a>
              <?php } ?>
              <?php if (!empty($member['linkedin']) && linkedin_validation($member['linkedin'])) { ?>
                <a href="<?php echo $member['linkedin'] ?>" target="_blank">
                  <i class="bi bi-linkedin"></i>
                </a>
              <?php } ?>
              <?php if (!empty($member['youtube']) && youtube_validation($member['youtube'])) { ?>
                <a href="<?php echo $member['youtube'] ?>" target="_blank">
                  <i class="bi bi-youtube"></i>
                </a>
              <?php } ?>
            </div>
          </div>
          <div class="info">
            <h3>
              <?php echo strtoupper($member['name']) ?>
            </h3>
            <p>
              <?php echo strtoupper($member['job_title']) ?>
            </p>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <!-- END TEAM MEMBERS -->
<?php } ?>