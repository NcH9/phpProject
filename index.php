<?
require __DIR__."/scripts/sessionScripts.php";
// var_dump($_COOKIE['rememberMe']);

require __DIR__ . '/vendor/autoload.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Backend</title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
</head>
<body>

    <div class="navPanel"><? include('./Views/NavPanel.php')?></div>
    <div class="flex-center">
        <div class="grid">
            <div class="flex-center"><h2 class="mg-5">Hello Backend World! It`s php project!</h2></div>
            <div>
                <img class="guyRitchi" src="./images/GuyRitchiFilm.png" title="Lock, Stock and Two Smoking Barrels">
            </div>
        </div>
    </div>

    



    <!-- <form method="post" action="Faker/db_seeder.php">
        <div>
            <span>
                Addresses amount
            </span>
            <input type="number" min="0" name="addresses_amount">
        </div>
        <div>
            <span>
                Users amount
            </span>
            <input type="number" min="0" name="users_amount">
        </div>
        <div>
            <span>
                Categories amount
            </span>
            <input type="number" min="0" name="categories_amount">
        </div>
        <div>
            <span>
                Posts amount
            </span>
            <input type="number" min="0" name="posts_amount">
        </div>
        <button type="submit" class="btn btn-primary">Seed</button>
    </form> -->
    <!-- <a href="faker.php">Fill database</a> -->
    
    

</body>
<script>
// window.addEventListener('beforeunload', function () {
//     navigator.sendBeacon('./scripts/logout.php');
// });
</script>
<style>
body {
    /* background: linear-gradient(0.25turn, rgba(0, 153, 255, 0.5), rgb(103, 149, 194)); */
    background-color: rgba(164, 202, 255, 0.5);
}
.navPanel {
    margin: 15px;
    padding: 15px;
}
.guyRitchi {
    border-radius: 10px;
    margin: 10px;
    border: solid 1px;
}
</style>
</html>