<?php 
    // cehck if action is set or not
    $action = isset($_GET['action']) & !empty($_GET['action']) ? $_GET['action'] : 'manage';

    if ($action == 'manage') {

        // include pieces types dashboard
        include_once 'pieces-types/dashboard.php';

    } elseif ($action == 'showPiecesType') {

        // get type of piece
        $typeid = isset($_GET['typeid']) && !empty($_GET['typeid']) ? $_GET['typeid'] : 0;
        
        // include sho pieces types module
        include_once 'pieces-types/show-pieces-types.php';
        
    } elseif ($action == 'insertPieceType') {

        // include insert pieces types module
        include_once 'pieces-types/insert-piece-type.php';
    
    } elseif ($action == 'updatePieceType') {

        // include update pieces types module
        include_once 'pieces-types/update-piece-type.php';
    
    } elseif ($action == 'deletePieceType') {

        // include delete pieces types module
        include_once 'pieces-types/delete-piece-type.php';

    } else {

        // include page not founded module
        include_once $globmod . 'page-error.php';
        
    }

?>