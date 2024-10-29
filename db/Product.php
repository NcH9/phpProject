<?php
require_once __DIR__ . '/../Source/Db.php';
use Palmo\Source\Db;

// $dbh = (new Db())->getHandler();
// $products = $dbh->query("SELECT * FROM Products")->fetchAll(PDO::FETCH_ASSOC);
// $categories = $dbh->query("SELECT * FROM Categories")->fetchAll(PDO::FETCH_ASSOC);
abstract class ProtoProduct {
    protected $dbh;
    public $categories = [];
    public function __construct() { 
        $this->dbh = (new Db())->getHandler();
        $this->getCategories();
    }
    public function getCategories() {
        $this->categories = $this->dbh->query("SELECT * FROM Categories")->fetchAll(PDO::FETCH_ASSOC);
    }
}
class Product extends ProtoProduct {
    public $products = [];
    public $allProducts = [];
    private $rowsPerPage = 10;
    public function __construct() { 
        parent::__construct();
    }
    public function getProducts($title, $category, $price, $sorter) {

        $sql = "SELECT * FROM Products WHERE 1=1";
        $params = []; 

        if (trim($title) != "") {
            $sql .= " AND title LIKE :title";
            $params[':title'] = '%' . $title . '%'; // % to search occurances not exact value
        }

        if (trim($category) != "") {
            $sql .= " AND category_id = :category";
            $params[':category'] = $this->getCategory($category);
        }

        if (is_numeric($price)) {
            $sql .= " AND price <= :price";
            $params[':price'] = $price;
        }

        if (trim($sorter) !== "0") {
            $sql .= match($sorter) {
                '1' => " ORDER BY title ASC",
                '2' => " ORDER BY title DESC",
                '3' => " ORDER BY price ASC",
                '4' => " ORDER BY price DESC",
                default => ""
            };
        }

        $start = 0;
        $rowsPerPage = 10;
        if (isset($_GET['page-nr'])) {
            $page = $_GET['page-nr'] - 1;
            $start = $page * $rowsPerPage;
        }

        $stmtAll = $this->dbh->prepare($sql);
        $stmtAll->execute($params);
        $this->allProducts = $stmtAll->fetchAll(PDO::FETCH_ASSOC);

        $sql .= " LIMIT $start, $rowsPerPage";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        $this->products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($this->products as &$product) { //& to change $this->products[$i] by changing $product in cycle
            $filteredCategories = array_filter($this->categories, function($category) use ($product) {
                return $category['id'] === $product['category_id'];
            });
            $category = array_shift($filteredCategories);
            $product['category'] = $category['name'];
        }
        unset($product);
    }
    public function amountOfPages():float {
        $amountOfPages = ceil(count($this->allProducts) / $this->rowsPerPage);

        return $amountOfPages;
    }
    public function getOneProduct($id) {

        $sql = "SELECT * FROM Products WHERE 1=1";
        $params = []; 

        if (is_numeric($id)) {
            $sql .= " AND id = :id";
            $params[":id"] = $id;
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        $this->products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $product = $this->products[0];
        $filteredCategories = array_filter($this->categories, function($category) use ($product) {
            return $category['id'] === $product['category_id'];
        });
        $category = array_shift($filteredCategories);
        $this->products[0]['category'] = $category['name'];
    }
    private function getCategory($categoryName) {
        $sql = "SELECT * FROM Categories WHERE name = :name";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $categoryName);
        $stmt->execute();
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($category)) {

            return $category['id'];
        } else {

            return NULL;
        }
    }
}

?>