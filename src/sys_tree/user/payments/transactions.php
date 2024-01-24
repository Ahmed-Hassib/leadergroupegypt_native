<?php
// create an object of Transaction class
$trans_obj = new Transaction();
// get malfunctions of today
$transactions = $trans_obj->get_all_transactions(base64_decode($_SESSION['sys']['company_id']));
?>
<div class="container" dir="<?php echo $page_dir ?>">
  <div class="mb-3 row row-cols-sm-1 g-3 align-items-stretch justify-content-start fs-12">
    <div class="col-12">
      <div class="section-block">
        <div class="table-responsive-sm">
          <table class="table table-bordered table-striped no-index display display-big-data compact table-style w-100 text-center">
            <thead class="primary text-capitalize">
              <tr>
                <th>#</th>
                <th>
                  <?php echo lang('is success', $lang_file) ?>
                </th>
                <th>
                  <?php echo lang('is pending', $lang_file) ?>
                </th>
                <th>
                  <?php echo lang('is refunded', $lang_file) ?>
                </th>
                <th>
                  <?php echo lang('price', $lang_file) ?>
                </th>
                <th>
                  <?php echo lang('currency', $lang_file) ?>
                </th>
                <th>
                  <?php echo lang('order id', $lang_file) ?>
                </th>
                <th>
                  <?php echo lang('source data type', $lang_file) ?>
                </th>
                <th>
                  <?php echo lang('source data pan', $lang_file) ?>
                </th>
                <th>
                  <?php echo lang('data message', $lang_file) ?>
                </th>
                <th>
                  <?php echo lang('created at', $lang_file) ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php if ($transactions != null) { ?>
                <?php foreach ($transactions as $index => $trans) { ?>
                  <tr class="text-<?php echo $_SESSION['sys']['lang'] == 'ar' ? 'right' : 'left' ?>">
                    <td><?php echo $index + 1 ?></td>
                    <td class="fs-12">
                      <?php if ($trans['is_success']) { ?>
                        <span class="badge rounded-pill bg-success">
                          <?php echo lang('success') ?>
                        </span>
                      <?php } else { ?>
                        <span>-</span>
                      <?php } ?>
                    </td>
                    <td class="fs-12">
                      <?php if ($trans['is_pending']) { ?>
                        <span class="badge rounded-pill bg-warning">
                          <?php echo lang('pending') ?>
                        </span>
                      <?php } else { ?>
                        <span>-</span>
                      <?php } ?>
                    </td>
                    <td class="fs-12">
                      <?php if ($trans['is_refunded']) { ?>
                        <span class="badge rounded-pill bg-warning">
                          <?php echo lang('refunded') ?>
                        </span>
                      <?php } else { ?>
                        <span>-</span>
                      <?php } ?>
                    </td>
                    <td><?php echo $trans['price'] ?></td>
                    <td><?php echo $trans['currency'] ?></td>
                    <td><?php echo $trans['order_id'] ?></td>
                    <td><?php echo $trans['source_data_type'] ?></td>
                    <td><?php echo $trans['source_data_pan'] ?></td>
                    <td dir="ltr"><?php echo $trans['data_message'] ?></td>
                    <td><?php echo $trans['created_at'] ?></td>
                  </tr>
                <?php } ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>