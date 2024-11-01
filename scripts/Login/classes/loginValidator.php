<?
namespace Palmo\scripts\Login\classes;
require_once __DIR__ . "/../../../db/User.php";
require_once __DIR__."/Username.php";
require_once __DIR__."/User.php";
use Palmo\db\User as dbUser;
use Palmo\scripts\Login\classes\User as loginUser;
use Palmo\scripts\Login\classes\Username;


class loginValidator {
    public $errorToDisplay, $user;
    public $loginSuccess = false;
    private $username;
    public function validateAll($username, $password):bool {
        if (!Username::validate($username)) {
            $this->errorToDisplay = "You entered the wrong username";

            return false;
        } else {

            $this->username = $username;
        }

        $user = loginUser::validate($username, $password);
        if ($user !== false) {
            $this->user = $user;

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
            $user = new dbUser();
            $secretKey = "077ebdc279135001cf1b14f8c900c068c62ca406e05d4da271e5862f12662a13";
            $token = $this->generateToken($this->user['id'], $secretKey);
            $user->updateUserToken($this->user['id'], $token);

            $_SESSION['user_token'] = $token;
            
            $_SESSION['user_id'] = $this->user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['admin'] = $this->user['admin'] == 1 ? true : false;
            $this->loginSuccess = true;
        }
    }
}