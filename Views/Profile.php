<?
require_once __DIR__."/../scripts/sessionScripts.php";

if (!isset($_SESSION['user_token'])) {
    header('Location: ../index.php');
    exit();
}


require_once __DIR__."/../db/User.php";

if (isset($_COOKIE['rememberMe'])) {
    if (isset($_SESSION['username'])) {
        $userStorage = new User();
        $currentUser = $userStorage->fetchUserByUsername($_SESSION['username']);
        if (!$currentUser) {
    
            session_destroy();
            header('Location: ../index.php');
            exit();
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logoutBtn'])) {
        if(isset($_COOKIE['rememberMe'])) {
            unset($_COOKIE['rememberMe']);
        }
        session_destroy();
        header('Location: ../index.php');
        exit();
    }

}
?>

<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
<div class="navPanel"><? include './NavPanel.php'; ?></div>

    <div class="flex-center">
        <div class="grid2">
            <div class="flex-center">
                <span class="span1">Username:</span>
                <?
                    echo $currentUser['username'];
                ?>
            </div>
            <div class="flex-center">
                <span class="span1">Rights:</span>
                <?
                    echo $currentUser['admin'] == true ? "admin" : "not admin";
                ?>
            </div>
            
        </div>
        <div class="margin">
            <div class="flex-center">
                <img src="<? echo $currentUser['pfp_path'];?>" class="pfp"/>
            </div>
        </div>
        
    </div>
    <div class="flex-center">
        <form method="POST">
            <button name="logoutBtn" type="submit" class="logoutBtn">Log Out</button>
        </form>
    </div>
</body>

<style>
.navPanel {
    margin: 15px;
    padding: 15px;
}
.logoutBtn {
    border-radius: 15px;
    border: 1px solid black;

    padding: 10px;
    margin: 10px;

    background-color: rgba(100, 200, 255, 0.5);
}
.span1 {
    padding: 5px;
    margin: 5px;
}
.pfp {
    max-width: 200px;
    max-height: 200px;

    border: 1px solid black;
}
.margin {
    margin: 15px;
}
</style>