<?
require __DIR__."/scripts/sessionScripts.php";
require_once __DIR__."/db/Hello.php";

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
</body>

<style>
body {
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