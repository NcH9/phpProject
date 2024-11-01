<?php
namespace Palmo\db;
require_once __DIR__.'/../Source/Db.php';
use Palmo\Source\Db;
use PDO, PDOException, DateTime;
abstract class ProtoUser {
    protected $dbh;
    protected $users = [];
    public function __construct() {
        $this->dbh = (new Db())->getHandler();
    }
    public function fetchUsers() {
        $sql = "SELECT * FROM Users";
        $params = [];

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute($params);
        $this->users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getUsers():array {
        return $this->users;
    }
}
class User extends ProtoUser {
    public function __construct() {
        parent::__construct();
    }
    // fetch methods
    public function fetchUserByCredentials($username, $password) {
        $sql = "SELECT * FROM Users WHERE username = :username";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($user)) {
            if (password_verify($password, $user['password']) || $password === $user['password']) {

                return $user;
            } else {
                
                return false;
            }
        }

        return false;
    }
    public function fetchUserByToken($username, $token) {
        $sql = "SELECT username, admin, pfp_path, token_expiration, email FROM Users WHERE token = :token AND username = :username";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($user)) {
            $currentTime = new DateTime();
            $tokenExpiration = DateTime::createFromFormat('Y-m-d H:i:s', $user['token_expiration']);
            if ($tokenExpiration > $currentTime) {

                return $user;
            } else {
                
                return false;
            }
        } else {

            return false;
        }
    }
    public function fetchUserByUsername($username) {
        $sql = "SELECT id, username, admin, pfp_path, token_expiration, email FROM Users WHERE username = :username";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($user)) {

            return $user;
        } else {

            return false;
        }
    }

    // set methods
    public function setNewPfp($id, $imgPath) {
        try {
            $sql = "UPDATE Users SET pfp_path = :imgPath WHERE id = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':imgPath', $imgPath);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function addUser($username, $password, $email, $birthDate, $admin, $pfp) {
        $sql = "INSERT INTO Users (username, password, email, birth_date, admin, pfp_path) 
            VALUES (:username, :password, :email, :birthDate, :admin, :pfp)";

        $stmt = $this->dbh->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birthDate', $birthDate);
        $stmt->bindParam(':admin', $admin, PDO::PARAM_BOOL);
        $stmt->bindParam(':pfp', $pfp);

        $stmt->execute();
    }
    public function updateUserToken($userId, $token):bool {
            $sql = "UPDATE Users SET token = :token, token_expiration = :expiration WHERE id = :userId";
            $stmt = $this->dbh->prepare($sql);
            

            $expiration = date('Y-m-d H:i:s', strtotime('+24 hours'));
            $stmt->bindParam(':token', $token, PDO::PARAM_STR);
            $stmt->bindParam(':expiration', $expiration);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_STR);
    
            $result = $stmt->execute();
            
            if ($result) {
    
                return true;
            } else {
                error_log("Error while updating user token: ".implode(', ', $stmt->errorInfo()));
    
                return false;
            }
    }

    // get methods
    public function getIfUsernameExists($username):bool {
        $sql = "SELECT * FROM Users WHERE username = :username";

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
    public function getIfEmailExists($email):bool {
        $sql = "SELECT * FROM Users WHERE email = :email";

        $stmt = $this->dbh->prepare($sql);
        $stmt->execute(['email'=>$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}
