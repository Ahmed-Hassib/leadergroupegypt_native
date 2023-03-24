<!-- pieces types statistics -->
            <div class="col-12">
                <div class="section-block" >
                    <div class="section-header">
                        <h5 class="h5 text-capitalize"><?php echo language('PIECES TYPES STATISTICS', @$_SESSION['systemLang']) ?></h5>
                        <p class="text-muted "><?php echo language('HERE WILL SHOW SOME STATISTICS ABOUT THE NUMBERS OF PIECES TYPES', @$_SESSION['systemLang']) ?></p>
                        <hr>
                    </div>
                    <?php 
                    // create an object of PiecesTypes
                    $types_obj = new PiecesTypes();
                    // get all types
                    $types_data = $types_obj->get_all_types($_SESSION['company_id']);
                    // types row
                    $types_rows = $types_data[1];
                    // types count
                    $types_count = $types_data[0];
                    ?>
                    <?php if ($types_count > 0) { ?>
                        <div class="table-responsive-sm" style="max-height: 300px; overflow-y: scroll;">
                            <table class="table table-striped table-bordered  display compact">
                                <thead class="primary text-capitalize">
                                    <tr>
                                        <th style="max-width: 25px">#</th>
                                        <th style="min-width: 100px"><?php echo language('CONNECTION TYPE', @$_SESSION['systemLang']) ?></th>
                                        <th style="min-width: 25px"><?php echo language('NUMBER OF PIECES', @$_SESSION['systemLang']) ?></th>
                                        <th style="min-width: 25px"><?php echo language('CONTROL', @$_SESSION['systemLang']) ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $index = 0; ?>
                                    <?php foreach ($types_rows as $key => $type) { ?>
                                        <tr>
                                            <td><?php echo ++$index; ?></td>
                                            <td><?php echo $type['type_name'] ?></td>
                                            <td>
                                                <span class="nums">
                                                    <?php $pcsCount = $types_obj->count_records("`piece_id`", "`pieces`", "WHERE `is_client` = 0 AND `type_id` = ".$type['type_id']); ?>
                                                    <span" class="num" data-goal="<?php echo $pcsCount ?>">0</a>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="pieces.php?name=pieces&do=piecesTypes&action=showPiecesType&typeid=<?php echo $type['type_id'] ?>" class="btn btn-outline-primary fs-12"><i class="bi bi-eye"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php $not_assigned_type = countRecords("`piece_id`", "`pieces`", "WHERE `is_client` = 0 AND `type_id` = 0"); ?>
                                    <?php if ($not_assigned_type > 0) { ?>
                                        <tr>
                                            <td><?php echo ++$index ?></td>
                                            <td><?php echo language('NOT ASSIGNED', @$_SESSION['systemLang']) ?></td>
                                            <td>
                                                <span class="nums">
                                                    <span" class="num" data-goal="<?php echo $not_assigned_type ?>">0</a>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="pieces.php?name=pieces&do=piecesTypes&action=showPiecesType&typeid=0" class="btn btn-outline-primary fs-12"><i class="bi bi-eye"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <h5 class="h5 text-capitalize text-danger"><?php echo language('THERE IS NO PIECES TYPES TO SHOW', @$_SESSION['systemLang']) ?></h5>
                        <a href="pieces.php?name=pieces&do=piecesTypes" class="btn btn-outline-primary py-1">
                            <h6 class="h6 mb-0 text-center text-capitalize fs-12">
                                <i class="bi bi-hdd-rack"></i>
                                <?php echo language('MANAGE', @$_SESSION['systemLang'])." ".language('PIECES TYPES', @$_SESSION['systemLang']) ?>
                            </h6>
                        </a>
                    <?php } ?>
                </div>
            </div>