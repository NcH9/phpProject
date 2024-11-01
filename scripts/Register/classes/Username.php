<?
namespace Palmo\scripts\Register\classes;
require_once __DIR__."/../interfaces/Validate1Reg.php";
use Palmo\scripts\Register\interfaces\Validate1Reg as Validate;
use Palmo\db\User;

class Username implements Validate {
    private $error, $result;
    public function __construct($username) {
        $this->result = $this->validate($username);
    }
    public function validate($username):bool {
        $username = trim($username);
        if (strlen($username) < 3) {
            $this->error = "Username should be at least 3 symbols long";

            return false;
        } else if (strlen($username) > 20) {
            $this->error = "Username should be not longer than 20 symbols";
            
            return false;
        }

        $user = new User();
        if ($user->getIfUsernameExists($username)) {
            $this->error = "This username is already taken";

            return false;
        }

        $this->username = $username;
        return true;
    }
    public function getError() {
        return $this->error;
    }
    public function getResult() {
        return $this->result;
    }
}