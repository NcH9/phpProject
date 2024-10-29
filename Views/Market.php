<?
require __DIR__."/../scripts/sessionScripts.php";

?>
<head>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/market.css">
    <title>Catalogue</title>
</head>
<body>
    <div class="navPanel"><? include './NavPanel.php'; ?></div>
</body>
<?php 
require_once __DIR__ . "/../db/Product.php";
require_once __DIR__ . "/../scripts/productInOutCart.php";

$productStorage = new Product();

if (isset($_POST['searchBtn'])) {
    $title = isset($_POST['product_title']) ? $_POST['product_title'] : "";
    $category = isset($_POST['product_category']) ? $_POST['product_category'] : "";
    $price = isset($_POST['product_price']) ? $_POST['product_price'] : "";

    $sorter = isset($_POST['sortProducts']) ? $_POST['sortProducts'] : "0";
} else {
    $title = isset($_GET['title']) ? $_GET['title'] : "";
    $category = isset($_GET['category']) ? $_GET['category'] : "";
    $price = isset($_GET['price']) ? $_GET['price'] : "";

    $sorter = isset($_GET['sorter']) ? $_GET['sorter'] : "0";
}

$productStorage->getProducts($title, $category, $price, $sorter);
?>

<div class="bgForShop">
<h1 class="flex-center">Catalogue</h1>

<!-- search and filters -->
<div class="flex-center">
    <button onclick="hideFilters()" class="searchBtn">Filters</button>
</div>
<script>
    function hideFilters() {
        if (document.getElementById('filterBubble').style.display != 'none') {
            document.getElementById('filterBubble').style.display = 'none';
        } else {
            document.getElementById('filterBubble').style.display = 'block';
        }
    }
</script>
<div class="filterBubble" id="filterBubble">
<div class="grid2">

    <div class="flex-center">
        <form method="POST">
            <div class="grid2">
            <div class="flex-center">
                <div class="gridFilters">
                    <span>Title: </span>
                    <input type="text" name="product_title" value="<? echo isset($title) ? htmlspecialchars($title) : ""; ?>"/>
                </div>
            </div>
            <div class="flex-center">
                <div class="gridFilters">
                    <span>Category: </span>
                    <select name="product_category">
                        <option value="">choose category...</option>
                        <?
                            foreach ($productStorage->categories as $categoria) {
                                ?>
                                <option 
                                value="<? echo htmlspecialchars($categoria['name']); ?>"
                                <? 
                                if (isset($category)) {
                                    echo $categoria['name'] === $category ? "selected" : "";
                                }
                                ?>
                                >
                                    <? echo htmlspecialchars($categoria['name']); ?>
                                </option>
                                <?
                            }
                        ?>
                    </select>
                </div>
                
            </div>
            <div class="flex-center">
                <div class="gridFilters">
                    <span>Price Limit: </span>
                    <input type="number" name="product_price" 
                    value="
                    <? 
                    if(isset($price)) {
                        print($price != (string)0 ? (float) htmlspecialchars($price) : (float) 999999999999999999);
                    } else {
                        echo (float) 999999999999999999;
                    }
                    ?>"
                    />
                </div>
            </div>
            <select name="sortProducts">
                <?
                    $sortersArray = ['1'=>'Alphabet FORWARDS','2'=>'Alphabet BACKWARDS','3'=>'Price UP','4'=>'Price DOWN'];
                ?>
                <option value="0">sort by...</option>
                <?
                    foreach ($sortersArray as $key => $item) {
                        ?>
                            <option 
                            value="<?echo htmlspecialchars($key);?>"
                            <? 
                                if (isset($sorter)) {
                                    echo $key == $sorter ? "selected" : "";
                                } 
                            ?>
                            >
                            
                                <?echo htmlspecialchars($item);?>
                            </option>
                        <?
                    }
                ?>
            </select>
            <div class="flex-center">
                <button type="submit" name="searchBtn" class="searchBtn">Search</button>
            </div>

            </div>
        </form>
    </div>

    <div class="flex-center">

    </div>
</div>
</div>

<!-- top pagination -->
<? include('./marketPagination.php');?>

<!-- products -->
<? foreach($productStorage->products as $product) {?>
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
<? }?>

<!-- bottom pagination -->
<? include('./marketPagination.php'); ?>