<?
    session_start();
?>
<?php
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
    <form method="post" action="./db_seeder.php">
        <div>
            <span>
                Categories amount
            </span>
            <input type="number" min="0" name="categories_amount">
        </div>
        <div>
            <span>
                Products amount
            </span>
            <input type="number" min="0" name="products_amount">
        </div>
        <button type="submit" class="btn btn-primary">Seed</button>
    </form>

    <form method="post" action="./db_seeder.php">
        <div>
            <span>
                Users amount
            </span>
            <input type="number" min="0" name="users_amount">
        </div>
        <button type="submit" class="btn btn-primary">Create users</button>
    </form>

    <a href="index.php">go back to index</a>
</body>
</html>
