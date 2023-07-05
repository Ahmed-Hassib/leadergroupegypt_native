<?php 
// check if CompSugg class object is created
if (!isset($comp_sugg_obj)) {
  $comp_sugg_obj = new CompSugg();
}
// get all complaints
$all_complaints = $comp_sugg_obj->get_all_complaints($_SESSION['UserID'], $_SESSION['company_id']);
?>
<div class="container mb-0" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="mb-3">
    <a href="?do=add-new-complaint" class="btn btn-outline-primary py-1 fs-12 shadow-sm">
      <i class="bi bi-plus"></i>
      <?php echo language('ADD NEW COMPLAINT', @$_SESSION['systemLang']) ?>
    </a>
  </div>
</div>
<!-- start new design -->
<div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start" dir="<?php echo @$_SESSION['systemLang'] == 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="stats">
    <div class="col-12">
      <div class="section-block">
        <header class="section-header">
          <h5 class="h5 text-capitalize"><?php echo language('TOTAL COMPLAINTS', @$_SESSION['systemLang']) ?></h5>
          <p class="text-muted "><?php echo language("HERE WILL SHOW ALL STATISTICS ABOUT MALFUNCTIONS TODAY", @$_SESSION['systemLang']) ?></p>
          <hr>
        </header>
        <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-4 gx-3 gy-5">
          <div class="col-6">
            <div class="card card-stat bg-total bg-gradient">
              <div class="card-body">
                <h5 class="card-title text-capitalize"><?php echo language('TOTAL', @$_SESSION['systemLang']) ?></h5>
                <span class="bg-info icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
                  <span class="nums">
                    <!-- <span class="num" data-goal="<?php echo $all_mal_today; ?>">0</span> -->
                  </span>
                </span>
                <a href="?do=show-malfunction-details&period=today&malStatus=all" class="stretched-link"></a>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card card-stat bg-danger bg-gradient">
              <div class="card-body">
                <h5 class="card-title text-capitalize"><?php echo language('UNFINISHED', @$_SESSION['systemLang']) ?></h5>
                <span class="bg-info icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
                  <span class="nums">
                    <!-- <span class="num" data-goal="<?php echo $unrep_mal_today; ?>">0</span> -->
                  </span>
                </span>
                <a href="?do=show-malfunction-details&period=today&malStatus=unrepaired" class="stretched-link"></a>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card card-stat bg-success bg-gradient">
              <div class="card-body">
                <h5 class="card-title text-capitalize"><?php echo language('FINISHED', @$_SESSION['systemLang']) ?></h5>
                <span class="bg-info icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
                  <span class="nums">
                    <!-- <span class="num" data-goal="<?php echo $rep_mal_today ?>">0</span> -->
                  </span>
                </span>
                <a href="?do=show-malfunction-details&period=today&malStatus=repaired" class="stretched-link"></a>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="card card-stat bg-warning bg-gradient">
              <div class="card-body">
                <h5 class="card-title text-capitalize"><?php echo language('DELAYED', @$_SESSION['systemLang']) ?></h5>
                <span class="bg-info icon-container <?php echo @$_SESSION['systemLang'] == 'ar' ? 'icon-container-left' : 'icon-container-right' ?>">
                  <span class="nums">
                    <!-- <span class="num" data-goal="<?php echo $del_mal_today ?>">0</span> -->
                  </span>
                </span>
                <a href="?do=show-malfunction-details&period=today&accepted=delayed" class="stretched-link"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
