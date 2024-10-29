<?
require __DIR__."/../scripts/sessionScripts.php";
if (isset($_SESSION['user_token'])) {
    header('Location: ./Error.php');
    exit();
}
require __DIR__."/../scripts/registerValidator.php";
require __DIR__."/../scripts/loginValidator.php";
$registerValidator = new registerValidator();
$loginValidator = new loginValidator();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($_FILES['pfp']['name'])) {
        $profileImage = $_FILES['pfp'];
    } else {
        $profileImage = null;
    }

    if (isset($_POST['admin'])) {
        $admin = true;
    } else {
        $admin = false;
    }

    if (!empty($_POST['birthdate'])) {
        $dateTime = DateTime::createFromFormat('Y-m-d', $_POST['birthdate']);
        $birthdate = $dateTime->format('Y-m-d');
    } else {
        $birthdate = null;
    }

    if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['email'])) {
        if ($registerValidator->registerSubmit(
            $username,
            $password,
            $email,
            $birthdate,
            $admin,
            $profileImage
        )) {
            $loginValidator->loginSubmit($username, $password);
            if ($loginValidator->loginSuccess) {
                header('Location: ../index.php');
                exit();
            }
        };
    } else {
        $requiredFields = "Fill all required fields (marked with * )";
    }
}
?>
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="grid2">
        <div class="navPanel"><? include './NavPanel.php'; ?></div>
        <div class="formForReg">
            <div class="grid2">
                <h2 class="flex-center">Register</h2>
                <form method="POST" class="formItself" enctype="multipart/form-data" id="uploadForm">
                    <div class="inputbubble">

                        <div class="grid2">

                            <div class="flex-center">
                                <span class="span1">Login<span class="error">*</span></span>
                                <input type="text" name="login" 
                                value="<? 
                                    echo isset($username) ? htmlspecialchars($username) : "";
                                ?>" required/>
                            </div>

                            <?
                                if($registerValidator->usernameError != null) {
                                    ?>
                                        <div class="error">
                                            <?
                                                echo $registerValidator->usernameError;
                                            ?>
                                        </div>
                                    <?
                                }
                            ?>

                        </div>

                        
                        
                    </div>
                    <div class="inputbubble">
                        <div class="grid2">

                            <div class="flex-center">
                                <span class="span1">Password<span class="error">*</span></span>
                                <input type="password" name="password" id="passwordInput"
                                value="<?
                                    echo isset($password) ? htmlspecialchars($password) : "";
                                ?>"
                                required/>
                                
                            </div>
                            <div class="flex-center">
                                <span class="span3">show password</span><input onchange="showPassword()" type="checkbox" id="passwordShow"/>
                            </div>
                            <?
                                if ($registerValidator->passwordError != null) {
                                    ?>
                                        <div class="error">
                                            <?
                                                echo $registerValidator->passwordError;
                                            ?>
                                        </div>
                                    <?
                                }
                            ?>

                            <script>
                                function showPassword() {
                                    if (document.getElementById("passwordShow").checked) {
                                        document.getElementById("passwordInput").type = "text";
                                    } else {
                                        document.getElementById("passwordInput").type = "password";
                                    }
                                }

                            </script>
                        </div>

                    </div>
                    <div class="inputbubble">
                        <div class="grid2">

                            <div class="flex-center">
                                <span class="span1">Email<span class="error">*</span></span>
                                <input type="email" name="email"
                                value="<?
                                    echo isset($email) ? htmlspecialchars($email) : "";
                                ?>"
                                required/>
                            </div>

                            <? 
                                if($registerValidator->emailError != null) {
                                    ?>
                                        <div class="error">
                                            <?
                                                echo $registerValidator->emailError."<br>";
                                            ?>
                                        </div>
                                    <?
                                }
                            ?>
                            
                        </div>

                    </div>
                    <div class="inputbubble">
                        <div class="grid2">
                            <div class="flex-center">
                                <span class="span1">Birthdate</span>
                                <input type="date" name="birthdate"
                                <? 
                                    // echo isset($birthdate) ? $birthdate->format('Y-m-d') : "";
                                ?>
                                />
                            </div>
                            <?
                                if ($registerValidator->birthDateError != null) {
                                    ?>
                                        <div class="error">
                                            <?
                                                echo $registerValidator->birthDateError."<br>";
                                            ?>
                                        </div>
                                    <?
                                }
                            ?>
                        </div>
                        
                    </div>

                    <div class="inputbubble">
                        <div class="flex-center">
                            <span class="span1">Admin</span>
                            <input type="checkbox" name="admin"
                            value="<?
                                echo isset($admin) ? $admin : false;
                            ?>"
                            />
                        </div>
                    </div>

                    <div class="inputbubble">
                        <div class="grid2">

                            <!-- <div class="flex-center">
                                <span class="span2">Profile img</span>
                                <input type="file" name="pfp"/>
                            </div> -->

                            <?
                                // if ($registerValidator->imgError != null) {
                                //     ?>
                                <!-- //         <div class="error">
                                //             <?
                                //                 echo $registerValidator->imgError."<br>";
                                //             ?>
                                //         </div> -->
                                    <?
                                // }
                            ?>
                            <div class="flex-center">
                                <div class="grid2">
                                    <div class="flex-center">
                                        <span class="span2">Profile img</span>
                                        <input type="file" name="pfp" id="fileInput"/>
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

                        </div>

                    </div>
                    
                    <?
                        if (isset($requiredFields)) {
                            ?>
                                <div class="error">
                                    <?
                                        echo $requiredFields."<br>";
                                    ?>
                                </div>
                            <?
                        }
                    ?>

                    <div class="flex-center">
                        <button type="submit" class="sbmt-btn">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<?php



?>


<style>
.navPanel {
    margin: 15px;
    padding: 15px;
}
.formForReg {
    margin: 30px;
    padding: 15px;

    display: flex;
    justify-content: center;
    place-items: center;
}
.inputbubble {
    /* display: flex;
    justify-content: center;
    place-items: center; */

    margin: 15px;
    padding: 10px;

    border: solid 1px black;
    border-radius: 15px;
    background: linear-gradient(0.25turn, rgba(19, 101, 97, 0.5), rgba(93, 113, 28, 0.622));

    box-shadow: 3px -3px 10px black;
}
.error {
    display: flex;
    justify-content: center;
    place-items: center;

    margin: 5px;

    color: rgba(194, 62, 62, 1);
}
.formItself {
    background: linear-gradient(0.25turn, rgba(0, 255, 242, 0.5), rgba(171, 207, 52, 0.622));
    border-radius: 15px;
    padding: 45px;

    box-shadow: 3px -3px 5px gray;
}
.span1 {
    display: flex;
    place-items: center;
    justify-content: center;

    margin: 5px;
    width: 100px;
    height: 25px;

    font-size: 20px;
    font-weight: 400;
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    text-shadow: 1px -1px 3px gray;
}
.span2 {
    display: flex;
    place-items: center;
    justify-content: center;

    margin: 15px;
    width: 100px;
    height: 25px;

    font-size: 15px;
    font-weight: 400;
    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    text-shadow: 1px -1px 3px gray;
}
.span3 {
    margin: 15px;
}
input {
    border-radius: 10px;
    border: solid 1px gray;
    box-shadow: 3px -3px 3px black;
    padding: 7px;
}
.sbmt-btn {
    margin: 15px;
    padding: 10px;

    background-color: rgba(123, 255, 47, 0.3);

    border-radius: 10px;

    font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
}
</style>