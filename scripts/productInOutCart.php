<?
function addToBag($id, $title, $category, $description, $price) {
    if (!isset($_SESSION['bag'][$id])) {
        $_SESSION['bag'][$id] = [
            'id' => $id,
            'title' => $title,
            'category' => $category,
            'description' => $description,
            'price' => $price,
        ];
    }
}
function deleteFromBag($id) {
    if (isset($_SESSION['bag'][$id])) {
        unset($_SESSION['bag'][$id]);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addToBagBtn'])) {
        $id = $_POST['Id'];
        $title = $_POST['Title'];
        $category = $_POST['Category'];
        $description = $_POST['Description'];
        $price = $_POST['Price'];

        addToBag($id, $title, $category, $description, $price);
    }

    if (isset($_POST['deleteFromBagBtn'])) {
        $id = $_POST['Id'];

        deleteFromBag($id);
    }
}
?>