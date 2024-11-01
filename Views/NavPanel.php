
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="panel">
        <div><a class="navLink" href="<? echo '../index.php'?>">Main</a></div>
        <div><a class="navLink" href="<? echo '/Views/Market.php'?>">Catalogue</a></div>
        <div><a class="navLink"href="<? echo '/Views/Bag.php';?>">Bag</a></div>
        <?
            if (isset($_SESSION['admin'])) {
                $admin = $_SESSION['admin'] == 1 ? true : false;
            } else {
                $admin = false;
            }
            if ($admin) {
                ?>
                    <div><a class="navLink" href="<? echo '/Views/AdminPanel.php'?>">Admin Panel</a></div>
                <?
            }
        ?>
        <?
            if (isset($_SESSION['user_token'])) {
                $isLoggedIn = true;
            } else {
                $isLoggedIn = false;
            }

            if ($isLoggedIn) {
                ?>
                    <div><a class="navLink" href="<? echo '/Views/Profile.php'?>">Profile</a></div>
                <?
            } else {
                ?>
                    <div><a class="navLink" href="<? echo '/Views/Login.php'?>">Login</a></div>
                    <div><a class="navLink" href="<? echo '/Views/Register.php'?>">Register</a></div>
                <?
            }
        ?>
    </div>
</body>

<style>
.navLink {
    color: black;

    border-radius: 25px;
    border: solid 1px;

    text-decoration: none;
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;

    padding: 10px;
    margin: 15px;

    background: linear-gradient(0.25turn, rgba(0, 153, 255, 0.5), rgb(103, 149, 194));
    opacity: 1;

    box-shadow: 3px -3px 5px gray;
}
.navLink:hover {
    color: white;
    opacity: 0.7;
    transition: 0.4s;
}
.panel {
    box-shadow: 3px -3px 5px black;
    background: linear-gradient(0.25turn, rgba(1, 95, 158, 0.5), rgba(48, 69, 91, 0.5));

    padding: 25px;
    border-radius: 5px;

    display: flex;
    justify-content: center;
    place-items: center;
}
</style>