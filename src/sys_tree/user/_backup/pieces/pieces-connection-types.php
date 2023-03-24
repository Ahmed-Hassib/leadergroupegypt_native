<?php 
    // cehck if action is set or not
    $action = isset($_GET['action']) & !empty($_GET['action']) ? $_GET['action'] : 'manage';

    if ($action == 'manage') {

        // include pieces conn dashboard
        include_once 'pieces-conn-types/dashboard.php';

    } else if ($action == 'showPiecesConn') {
        
        // get type of piece
        $type = isset($_GET['type']) && !empty($_GET['type']) ? $_GET['type'] : 0;
        
        // get type of piece
        $connid = isset($_GET['connid']) && !empty($_GET['connid']) ? $_GET['connid'] : 0;

        // include show pieces conn module
        include_once 'pieces-conn-types/show-pieces-conn.php';
        
    } else if ($action == 'insertPieceConnType') {

        // include insert pieces conn module
        include_once 'pieces-conn-types/insert-conn-type.php';
        
    } else if ($action == 'updatePieceConnType') {

        // include update pieces conn module
        include_once 'pieces-conn-types/update-conn-type.php';
    
    } else if ($action == 'deletePieceConnType') {

        // include delete pieces conn module
        include_once 'pieces-conn-types/delete-conn-type.php';

    } else {

        // include page not founded module
        include_once $globmod . 'page-error.php';
        
    }

?>