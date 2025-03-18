<?
require_once __DIR__."/../db/Product.php";
function addToBag($id):bool {
    $currentProduct = new Product();
    $currentProduct = $currentProduct->getOneProduct($id);
    if ($currentProduct === false) {
        
        return false;
    }

    if (!isset($_SESSION['bag'][$id])) {
        $_SESSION['bag'][$id] = [
            'id' => $currentProduct['id'],
            'title' => $currentProduct['title'],
            'category' => $currentProduct['category'],
            'description' => $currentProduct['description'],
            'price' => $currentProduct['price'],
        ];
    }
    return true;
}
function deleteFromBag($id) {
    if (isset($_SESSION['bag'][$id])) {
        unset($_SESSION['bag'][$id]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addToBagBtn'])) {
        $id = $_POST['Id'];

        if (addToBag($id)) {
            echo "<script>alert('success!');</script>";
        } else {
            echo "<script>alert('you are trying to add product that no longer exist!');</script>";
        }
    }

    if (isset($_POST['deleteFromBagBtn'])) {
        $id = $_POST['Id'];

        deleteFromBag($id);
    }
}