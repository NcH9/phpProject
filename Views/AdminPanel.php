<?
require_once __DIR__."/../scripts/sessionScripts.php";

    if (!isset($_SESSION['user_token']) || $_SESSION['admin'] == false) {
        header('Location: ./Error.php');
        exit();
    }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Panel</title>
  <base href="/">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="./favicon.ico">
</head>
<body>
    <div class="navPanel"><? include('./NavPanel.php')?></div>
    <a href="faker.php">Fill database</a>
    

    <?

        require_once __DIR__ . "/../db/User.php";
        $user = new User();
        $user->fetchUsers();
        echo "<br>All users:";
        foreach ($user->getUsers() as $user) {
            ?>
                <div class="microbubble">
                    <div class="grid4">

                        <div class="gridDouble">
                            <div>id: </div>
                            <div><? echo "".$user['id']."<br>"; ?></div>
                        </div>

                        <div class="gridDouble">
                            <div>username: </div>
                            <div><? echo "".$user['username']."<br>"; ?></div>
                        </div>

                        <!-- <div class="gridDouble">
                            <div>password:</div>
                            <div><? //echo "".$user['password']."<br>"; ?></div>
                        </div> -->

                        <div class="gridDouble">
                            <div>email: </div>
                            <div><? echo "".$user['email']."<br>"; ?></div>
                        </div>

                        <div class="gridDouble">
                            <div>birth_date: </div>
                            <div><? echo "".$user['birth_date']."<br>"; ?></div>
                        </div>

                        <div class="gridDouble">
                            <div>is admin: </div>
                            <div><? echo ($user['admin'] ? "admin" : "not admin")."<br>"; ?></div>
                        </div>

                    </div>

                    <div class="grid4">
                        <span>profile picture:</span>
                        
                        <? 
                            if ($user['pfp_path'] != null) {
                                ?>
                                    <img src="<? echo $user['pfp_path'];?>"/>
                                <?
                            } else {
                                ?>
                                    <div>This user has no pfp</div>
                                <?
                            }
                        ?>
                    </div>
                    
                </div>
            <?
        }

    ?>

</body>

<style>
.navPanel {
    margin: 15px;
    padding: 15px;
}
.microbubble {
    border-radius: 15px;
    border: 1px solid black;
    
    margin: 10px;
    padding: 10px;

    display: flex;
    justify-content: center;
    place-items: center;
}
.grid4 {
    display: grid;
    margin: 10px;
}
.gridDouble {
    display: grid;
    grid-template-columns: repeat(2, 200px);
}
img {
    width: 100px;
    height: 100px;
}
</style>
</html>
