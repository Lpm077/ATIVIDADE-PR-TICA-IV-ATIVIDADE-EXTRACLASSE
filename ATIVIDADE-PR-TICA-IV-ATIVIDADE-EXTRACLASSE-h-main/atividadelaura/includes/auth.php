<?php
if(session_status()===PHP_SESSION_NONE) session_start();
function is_logged(){
    return !empty($_SESSION['user_id']);
}
function require_login(){
    if(!is_logged()){
        header('Location: /atividade/public/login.php');
        exit;
    }
}
function login_user($user_id,$user_name){
    if(session_status()===PHP_SESSION_NONE) session_start();
    session_regenerate_id(true);
    $_SESSION['user_id']=$user_id;
    $_SESSION['user_name']=$user_name;
}
function logout_user(){
    if(session_status()===PHP_SESSION_NONE) session_start();
    $_SESSION=[];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
