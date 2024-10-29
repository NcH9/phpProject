<?
require __DIR__."/../scripts/sessionScripts.php";

?>
<head>
    <link rel="stylesheet" href="../css/styles.css">
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
<div class="filterBubble">
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
                        echo $price != (string)0 ? htmlspecialchars($price) : 999999999999999999;
                    } else {
                        echo 999999999999999999;
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
                <!-- <option value="1">Alphabet FORWARDS</option>
                <option value="2">Alphabet BACKWARDS</option>

                <option value="3">Price UP</option>
                <option value="4">Price DOWN</option> -->
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
<div>
    <div class="flex-center">
        <? 
            if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {
                $prevPage = "?page-nr=".($_GET['page-nr']-1)."&title=".urlencode($title)."&category=".urlencode($category)."&price=".urlencode($price)."&sorter=".urlencode($sorter);
                ?>
                    <a class="pagination" href="<?echo $prevPage;?>">Previous</a>
                <? 
            } else {
                ?>
                    <a class="pagination">Previous</a>
                <? 
            }
        ?>
            <div>
        <? 
            if (isset($_GET['page-nr'])) {
                echo $_GET['page-nr'];
            } else {
                echo '1';
            }
            echo '/';
            echo $productStorage->amountOfPages();
        ?>
            </div>
        <? 
            if (!isset($_GET['page-nr']) || $_GET['page-nr'] == 1) {
                $pageTwo = "?page-nr=2&title=".urlencode($title)."&category=".urlencode($category)."&price=".urlencode($price)."&sorter=".urlencode($sorter);
                ?>
                    <a class="pagination" href="<?echo $pageTwo;?>">Next</a>
                <? 
            } else if ($_GET['page-nr'] >= $productStorage->amountOfPages()) { 
                ?>
                    <a class="pagination">Next</a>
                <? 
            } else {
                $nextPage = "?page-nr=".($_GET['page-nr']+1)."&title=".urlencode($title)."&category=".urlencode($category)."&price=".urlencode($price)."&sorter=".urlencode($sorter);
                ?>
                    <a class="pagination" href="<? echo $nextPage; ?>">Next</a>
                <?  
            }
        ?>
    </div>
</div>

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
<div>
    <div class="flex-center">
        <? 
            if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {
                $prevPage = "?page-nr=".($_GET['page-nr']-1)."&title=".urlencode($title)."&category=".urlencode($category)."&price=".urlencode($price)."&sorter=".urlencode($sorter);
                ?>
                    <a class="pagination" href="<?echo $prevPage;?>">Previous</a>
                <? 
            } else {
                ?>
                    <a class="pagination">Previous</a>
                <? 
            }
        ?>
            <div>
        <? 
            if (isset($_GET['page-nr'])) {
                echo $_GET['page-nr'];
            } else {
                echo '1';
            }
            echo '/';
            echo $productStorage->amountOfPages();
        ?>
            </div>
        <? 
            if (!isset($_GET['page-nr']) || $_GET['page-nr'] == 1) {
                $pageTwo = "?page-nr=2&title=".urlencode($title)."&category=".urlencode($category)."&price=".urlencode($price)."&sorter=".urlencode($sorter);
                ?>
                    <a class="pagination" href="<?echo $pageTwo;?>">Next</a>
                <? 
            } else if ($_GET['page-nr'] >= $productStorage->amountOfPages()) { 
                ?>
                    <a class="pagination">Next</a>
                <? 
            } else {
                $nextPage = "?page-nr=".($_GET['page-nr']+1)."&title=".urlencode($title)."&category=".urlencode($category)."&price=".urlencode($price)."&sorter=".urlencode($sorter);
                ?>
                    <a class="pagination" href="<? echo $nextPage; ?>">Next</a>
                <?  
            }
        ?>
    </div>
</div>

<style>
.grid {
    display: grid;
    background-color: rgba(66, 165, 201, 0.65);
    margin: 10px;
    padding: 10px;
    color: black;
    border-radius: 15px;
    border: 1px solid rgba(0, 0, 0, 0.5);
    box-shadow: 3px -3px 5px rgba(0, 0, 0, 0.5);
}
.flex-center {
    display: flex;
    justify-content: center;
    place-items: center;
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

.bubble{
    background-color: rgba(66, 165, 201, 0.65);
    display: flex;
    justify-content: center;
    margin: 10px;
    padding: 10px;
    color: black;
    border-radius: 15px;
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

a {
    text-decoration: none;
    color: black;
}
.pagination {
    border: 1px solid;
    padding: 15px;
    margin: 15px;
    border-radius: 10px;
    background: linear-gradient(0.25turn, rgba(0, 153, 255, 0.5), rgb(103, 149, 194));
    opacity: 1;
}
.pagination:hover {
    opacity: 0.7;
    color: white;
    transition: 0.3s;
}
.navPanel {
    margin: 15px;
    padding: 15px;
}
.bgForShop {
    /* background-color: rgba(91, 168, 255, 0.5);*/
    background: linear-gradient(0.25turn, rgba(0, 153, 255, 0.5), rgb(103, 149, 194));

    border-radius: 15px;
    padding: 150px;
    margin: 50px;
    padding-top: 15px;
}


input {
    border-radius: 15px;
    border: none;
    padding: 5px;
    margin: 5px;
    min-width: 175px;
}
select {
    border-radius: 15px;
    border: none;
    padding: 5px;
    margin: 5px;
    min-width: 175px;

}
.gridFilters {
    display: grid;
    place-items: center;
    grid-template-columns: repeat(2, 1fr);
    margin: 10px;
}
.searchBtn {
    border-radius: 15px;
    border: 1px solid;
    border-color: black;
    padding: 15px;
    background-color: white;
}
.filterBubble {
    /* background-color: blue; */
}
</style>