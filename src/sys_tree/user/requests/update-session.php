<?php 
    // get user id 
    $user_id = isset($_GET['user-id']) ? $_GET['user-id'] : 0;
    // create an object of Session class
    $session_obj = new Session();
    // get user info
    $user_info = $session_obj->get_user_info($user_id);
    // check if done
    if ($user_info[0] == true) {
        // set user session
        $session_obj->set_user_session($user_info[1]);
    }

    // redirect to the home
    redirectHome("", "back", 0);
