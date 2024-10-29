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