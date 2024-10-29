<?
session_start();

require_once __DIR__."/../db/User.php";

if (!isset($_COOKIE['rememberMe'])) {

    // var_dump('no cookies? ;D');
    $userStorage = new User();
    if (isset($_SESSION['user_token']) && isset($_SESSION['username'])) {
        $currentUser = $userStorage->fetchUserByToken($_SESSION['username'], $_SESSION['user_token']);
        if (!$currentUser) {
    
            session_destroy();
        }
    }
} else {

    // var_dump($_COOKIE['rememberMe']);
}

?>