<?php

use Palmo\Source\Db;

require_once '../vendor/autoload.php';

set_time_limit(0);

$dbh = (new Db())->getHandler();

$faker = Faker\Factory::create();
$faker->addProvider(new Faker\Provider\en_US\Address($faker));
$faker->addProvider(new Faker\Provider\en_US\Person($faker));
$faker->addProvider(new Faker\Provider\en_US\Company($faker));
$faker->addProvider(new Faker\Provider\en_US\PhoneNumber($faker));
$faker->addProvider(new Faker\Provider\en_US\Text($faker));


if (!empty($_POST['categories_amount'])) {
    $categoryAmount = $_POST['categories_amount'];
    for ($i = 0; $i < $categoryAmount; $i++) {
        $categoryName = $faker->word;
        if (str_contains($categoryName, "'")) {
            $categoryName = str_replace("'", "\'", $categoryName);
        }
        $dbh->query("
            INSERT INTO Categories (`name`)
            VALUES ('{$categoryName}')
        ");
    }
}

if (!empty($_POST['products_amount'])) {
    $postAmount = $_POST['products_amount'];
    $categoryIds = $dbh->query('SELECT id FROM Categories')->fetchAll(PDO::FETCH_COLUMN);
    for ($i = 0; $i < $postAmount; $i++) {
        $key = array_rand($categoryIds);
        $categoryId = $categoryIds[$key];

        $title = $faker->text(50);
        if (str_contains($title, "'")) {
            $title = str_replace("'", "\'", $title);
        }

        $description = $faker->text(500);
        if (str_contains($description, "'")) {
            $description = str_replace("'", "\'", $description);
        }

        $price = $faker->randomFloat();

        $dbh->query("
            INSERT INTO Products (title, category_id, description, price)
            VALUES ('{$title}', '{$categoryId}', '{$description}', '{$price}')
        ");
    }
}

if (!empty($_POST['products_amount'])) {
    $postAmount = $_POST['products_amount'];
    $categoryIds = $dbh->query('SELECT id FROM Categories')->fetchAll(PDO::FETCH_COLUMN);
    for ($i = 0; $i < $postAmount; $i++) {
        $key = array_rand($categoryIds);
        $categoryId = $categoryIds[$key];

        $title = $faker->text(50);
        if (str_contains($title, "'")) {
            $title = str_replace("'", "\'", $title);
        }

        $description = $faker->text(500);
        if (str_contains($description, "'")) {
            $description = str_replace("'", "\'", $description);
        }

        $price = $faker->randomFloat();

        $dbh->query("
            INSERT INTO Products (title, category_id, description, price)
            VALUES ('{$title}', '{$categoryId}', '{$description}', '{$price}')
        ");
    }
}


if (!empty($_POST['users_amount'])) {
    $postAmount = $_POST['users_amount'];
    for ($i = 0; $i < $postAmount; $i++) {
        
        $username = $faker->text(15);
        if (str_contains($username, "'")) {
            $username = str_replace("'", "\'", $username);
        }
        if (str_contains($username, " ")) {
            $username = str_replace(" ", "", $username);
        }
        if (str_contains($username, ".")) {
            $username = str_replace(".", "", $username);
        }

        $password = $faker->text(15);
        if (str_contains($password, " ")) {
            $password = str_replace(" ", "", $password);
        }
        if (str_contains($password, ".")) {
            $password = str_replace(".", "", $password);
        }

        $birthDate = $faker->dateTimeBetween('1960-01-01', 'now')->format('Y-m-d');

        $admin = $faker->boolean(10) ? 1 : 0;

        $dbh->query("
            INSERT INTO Users (username, password, birth_date, admin)
            VALUES ('{$username}', '{$password}', '{$birthDate}', '{$admin}')
        ");
    }
}

header('Location: ../index.php');


?>