<?
require __DIR__."/../scripts/sessionScripts.php";

?>
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<div class="navPanel"><? include('./NavPanel.php')?></div>

<?php 
require __DIR__ .'/../db/Product.php';
require __DIR__ . "/../scripts/productInOutCart.php";

$product = new Product();

if (isset($_GET["product_id"])) {
    $productId = $_GET['product_id'];
    $product->getOneProduct($productId);
    if ($product->products[0]) {
        $product = $product->products[0]; ?>
            <div class="grid">

            <div class="minibubble">
                <span>ID: </span>
                <span>
                    <?php echo $product['id']; ?>
                </span>
            </div>

            <div class="minibubble">
                <span>Title: </span>
                <span>
                    <?php echo $product['title']; ?>
                </span>
            </div>

            <div class="minibubble">
                <span>Category: </span>
                <span>
                    <?php echo $product['category'];?>
                </span>
            </div>

            <div class="minibubble">
                <span>Description: </span>
                <span>
                    <?php echo $product['description']; ?>
                </span>
            </div>

            <div class="minibubble">
                <span>Price: </span>
                <span>
                    <?php echo $product['price']; ?>
                </span>
            </div>

            <div class="flex-center">
                <?
                    if (!isset($_SESSION['bag'][$product['id']])) {
                        ?>
                            <div class="flex-center">
                                <form method="POST">
                                    <input type="hidden" name="Id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                    <input type="hidden" name="Title" value="<?php echo htmlspecialchars($product['title']); ?>">
                                    <input type="hidden" name="Category" value="<?php echo htmlspecialchars($product['category']); ?>">
                                    <input type="hidden" name="Description" value="<?php echo htmlspecialchars($product['description']); ?>">
                                    <input type="hidden" name="Price" value="<?php echo htmlspecialchars($product['price']); ?>">

                                    <button type="submit" class="addButton" name="addToBagBtn">Add To Bag</button>
                                </form>
                            </div>
                        <?
                    } else {
                        ?>
                            <div class="flex-center">
                                <form method="POST">
                                    <input type="hidden" name="Id" value="<?php echo htmlspecialchars($product['id']); ?>">

                                    <button type="submit" class="addButton" name="deleteFromBagBtn">Delete From Bag</button>
                                </form>
                            </div>
                        <?
                    }
                ?>
            </div>
            </div>
        <?php
    }


} else {
    echo "ID is not specified";
}


?>
<head>
    <meta charset="utf-8">
    <title><? echo $product['title'] ?></title>
    <base href="/">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="./favicon.ico">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<style>
.navPanel {
    margin: 15px;
    padding: 15px;
}
.addButton {
    border-radius: 15px;
    border: 1px solid;
    border-color: rgb(0, 229, 255);
    padding: 15px;
    background-color: white;
}
.addButton:hover {
    background-color: rgba(19, 18, 67, 0.65);
    transition: 0.5s;
    color: white;
}
.addButton:active {
    background-color: rgba(19, 18, 67, 0.95);
    transition: 0.1s;
    color: white;
}
</style>