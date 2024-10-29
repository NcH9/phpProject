<?
require __DIR__."/../scripts/sessionScripts.php";

require __DIR__ . "/../scripts/productInOutCart.php";

?>
<head>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="navPanel"><? include './NavPanel.php'; ?></div>
    <?
    
    if (isset($_SESSION['bag']) && !empty($_SESSION['bag'])) {
        foreach ($_SESSION['bag'] as $product) {
            
            ?>

                <a href="./Product.php?product_id=<?php echo $product['id']; ?>" title="See more info on <?php echo htmlspecialchars($product['title']); ?>">
                    <div class="flex-center">
                        <div class="grid">

                            <div class="flex-center">
                                <div class="minibubble">
                                    <span>Title: </span>
                                    <span>
                                        <?php echo $product['title']; ?>
                                    </span>
                                </div>
                            </div>

                            <div class="flex-center">
                                <div class="minibubble">
                                    <span>Category: </span>
                                    <span>
                                        <?php echo $product['category'];?>
                                    </span>
                                </div>
                            </div>

                            <div class="flex-center">
                                <div class="minibubble">
                                    <span>Price: </span>
                                    <span>
                                        <?php echo $product['price']; ?>
                                    </span>
                                </div>
                            </div>

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
                </a>
            <?
        }
    }
    
    ?>

</body>
<script>
window.addEventListener('beforeunload', function () {
    // Отправляем запрос к серверу при закрытии
    navigator.sendBeacon('./scripts/logout.php');
});
</script>
<style>
.navPanel {
    margin: 15px;
    padding: 15px;
}

.minibubble {
    background-color: rgba(29, 62, 111, 0.5);
    display: flex;
    justify-content: center;
    margin: 10px;
    padding: 10px;
    color: black;
    border-radius: 5px;

    min-width: 400px;
    box-shadow: 3px -3px 5px rgba(0,0,0,0.5);
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

a {
    text-decoration: none;
}

</style>