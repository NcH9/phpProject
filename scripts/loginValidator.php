<?

require_once __DIR__ . "/../db/User.php";

class loginValidator {
    public $errorToDisplay, $user;
    public $loginSuccess = false;
    private $username;
    private function validateExistingLogin($username):bool {
        if (strlen(trim($username)) < 3) {

            return false;
        }

        $user = new User();
        if ($user->getIfUsernameExists($username)) {
            $this->username = $username;

            return true;
        }

        return false;
    }
    private function validateUser($username, $password):bool {
        if (strlen(trim($username)) < 3 || strlen(trim($password)) < 5) {

            return false;
        }

        $user = new User();
        $user = $user->fetchUserByCredentials($username, $password);

        if ($user !== false) {          
            $this->user = $user;

            return true;
        }

        return false;
    }
    public function validateAll($username, $password):bool {
        if (!$this->validateExistingLogin($username)) {
            $this->errorToDisplay = "You entered the wrong username";

            return false;
        }

        if ($this->validateUser($username, $password) != false) {

            return true;
        }

        $this->errorToDisplay = "You entered the wrong data";

        return false;
    }
    private function generateToken($userId, $secretKey) {
        $randomBytes = random_bytes(32);
        $timestamp = time();
        return hash_hmac('sha256', $userId.$randomBytes.$timestamp,$secretKey);
    }
    public function loginSubmit($username, $password) {
        if ($this->validateAll($username, $password)) {
            $user = new User();
            // echo "tyt dolzhna butb logika";
            $secretKey = "077ebdc279135001cf1b14f8c900c068c62ca406e05d4da271e5862f12662a13";
            // var_dump($this->user);
            $token = $this->generateToken($this->user['id'], $secretKey);
            // echo $token;
            $user->updateUserToken($this->user['id'], $token);

            $_SESSION['user_token'] = $token;
            
            $_SESSION['user_id'] = $this->user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['admin'] = $this->user['admin'] == 1 ? true : false;
            $this->loginSuccess = true;
        }
    }
}

?>