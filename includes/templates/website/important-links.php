<?php
// create an object of Link class
$link_obj = !isset($link_obj) ? new Link() : $link_obj;
// get all active links
$active_links = $link_obj->get_active_links();
// check links
if ($active_links != null && count($active_links) > 0) {
?>
  <div class="box">
    <ul class="links">
      <?php foreach ($active_links as $key => $link) { ?>
        <li><a href="<?php echo $link['link'] ?>"><?php echo $lang == 'ar' ? $link['link_name_ar'] : $link['link_name_en'] ?></a></li>
      <?php } ?>
    </ul>
  </div>
<?php } ?>