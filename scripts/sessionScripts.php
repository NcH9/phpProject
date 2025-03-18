<?
session_start();

require_once __DIR__."/../db/User.php";
use Palmo\db\User;

if (!isset($_COOKIE['rememberMe'])) {

    $userStorage = new User();
    if (isset($_SESSION['user_token']) && isset($_SESSION['username'])) {
        $currentUser = $userStorage->fetchUserByToken($_SESSION['username'], $_SESSION['user_token']);
        if (!$currentUser) {
    
            session_destroy();
        }
    }
} else {

    //
}
