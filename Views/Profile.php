<?
require_once __DIR__."/../scripts/sessionScripts.php";
require_once __DIR__."/../scripts/registerValidator.php";

if (!isset($_SESSION['user_token'])) {
    header('Location: ../index.php');
    exit();
}


require_once __DIR__."/../db/User.php";
$userStorage = new User();
$currentUser = $userStorage->fetchUserByUsername($_SESSION['username']);
if (isset($_COOKIE['rememberMe'])) {
    if (isset($_SESSION['username'])) {
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

    if (!empty($_FILES['newPfp']['name']) && $_FILES['newPfp']['size'] < 1024000) {
        if (isset($_POST['confirmChangesBtn'])) {

            $picPath = $_FILES['newPfp'];
            $registerValidator = new registerValidator();
            if ($registerValidator->validateImage($picPath)) {
                $registerValidator->addImage($picPath);
                $userStorage->setNewPfp($currentUser['id'], $registerValidator->image);
                header("Location: " . $_SERVER['PHP_SELF']); // redirecting to the same page
                exit();
            }
        }
    }
}
?>

<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
<div class="navPanel"><? include './NavPanel.php'; ?></div>

    <div class="flex-center">
        <div id="userData" class="flex-center">
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

    </div>
    <div class="grid2">
        <div class="flex-center">
            <button onclick="showChangeUserData()" class="logoutBtn">Redact Your Profile</button>
            <script>
                function showChangeUserData() {
                    if (document.getElementById('changeUserData').style.display != 'block') {
                        document.getElementById('changeUserData').style.display = 'block';
                    } else {
                        document.getElementById('changeUserData').style.display = 'none';
                    }
                }
            </script>
        </div>    

        <div id="changeUserData" class="flex-center">
            <div class="flex-center">
                
                <form method="POST" id="uploadForm" enctype="multipart/form-data">
                    <div class="grid2">                      

                        <div class="flex-center">
                            <div class="grid2">
                                <div class="flex-center">
                                    <span class="span1">New Picture</span>
                                    <input type="file" name="newPfp" id="fileInput"/>
                                </div>
                                <div class="flex-center"><span class="error" id="errorMessage"></span></div>
                            </div>
                        </div>
                        <script>
                            const fileInput = document.getElementById('fileInput');
                            const uploadForm = document.getElementById('uploadForm');
                            const errorMessage = document.getElementById('errorMessage');

                            const maxFileSize = 1024 * 1024; // 1 MB

                            uploadForm.addEventListener('submit', function (event) {
                                const file = fileInput.files[0];

                                if (file && file.size > maxFileSize) {
                                    event.preventDefault(); // cancels form submit
                                    errorMessage.textContent = 'Pfp is too big, maximum size: 1mb.';
                                } else {
                                    errorMessage.textContent = '';
                                }
                            });
                        </script>

                        <div class="flex-center">
                            <button type="submit" name="confirmChangesBtn" class="logoutBtn">Confirm Changes</button>
                        </div>
                    </div>
                </form>

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
#changeUserData {
    display: none;
}
input {
    border: none;
    border-radius: 15px;

    padding: 7px;

}
.error {
    color: rgba(194, 62, 62, 0.85);
}
</style>