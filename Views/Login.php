<?
require __DIR__."/../scripts/sessionScripts.php";

if (isset($_SESSION['user_token'])) {
    header('Location: ./Error.php');
    exit();
}
require __DIR__."/../scripts/Login/classes/loginValidator.php";
use Palmo\scripts\Login\classes\loginValidator;
$loginValidator = new loginValidator();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($_POST['rememberMe'])) {
        $rememberMe = true;
    } else {
        $rememberMe = false;
    }

    $loginValidator->loginSubmit($username, $password);
    if ($loginValidator->loginSuccess) {
        if ($rememberMe) {
            setcookie('rememberMe', true, time() + (365 * 24 * 60 * 60), '/');
        }

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

    <div class="formForLogin">
        <div class="grid2">
            <h2 class="flex-center">Login</h2>
            <form method="POST" class="formItself">
                <div class="inputbubble">

                    <div class="grid2">

                        <div class="flex-center">
                            <span class="span1">Login</span></span>
                            <input type="text" name="login" 
                            value="<? 
                                echo isset($username) ? htmlspecialchars($username) : "";
                            ?>" required/>
                        </div>

                    </div>

                    
                    
                </div>
                <div class="inputbubble">
                    <div class="grid2">

                        <div class="flex-center">
                            <span class="span1">Password</span></span>
                            <input type="password" name="password" id="passwordInput"
                            value="<?
                                echo isset($password) ? htmlspecialchars($password) : "";
                            ?>"
                            required/>
                        </div>
                        <div class="flex-center">
                            <span class="span3">show password</span><input onchange="showPassword()" type="checkbox" id="passwordShow" />
                        </div>
                    </div>
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

                <div class="flex-center">Remember me:<input type="checkbox" name="rememberMe" 
                    <? 
                    echo isset($rememberMe) && $rememberMe ? 'checked' : '';
                    ?>
                />
                </div>

                <?
                    if ($loginValidator->errorToDisplay != null) {
                        ?>
                            <div class="error">
                                <?
                                    echo $loginValidator->errorToDisplay;
                                ?>
                            </div>
                        <?
                    }
                ?>

                <div class="flex-center">
                    <button type="submit" class="sbmt-btn">Login</button>
                </div>
            </form>
        </div>
    </div>

</body>
<style>
.navPanel {
    margin: 15px;
    padding: 15px;
}
.formForLogin {
    margin: 30px;
    padding: 15px;

    display: flex;
    justify-content: center;
    place-items: center;
}
.inputbubble {
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
.grid2 {
    display: grid;
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
.span3 {
    margin: 10px;
}
</style>
