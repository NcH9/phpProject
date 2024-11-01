<?
namespace Palmo\scripts\Register\classes;
require_once __DIR__."/../interfaces/Validate1Reg.php";
use Palmo\scripts\Register\interfaces\Validate1Reg as Validate;
use Palmo\db\User;

class Email implements Validate {
    private $error, $result;
    public function __construct($email) {
        $this->result = $this->validate($email);
    }
    public function validate($email):bool {
        $email = trim($email);
        $user = new User();

        if ($user->getIfEmailExists($email)) {
            $this->error = "This email is registered";

            return false;
        }

        if (strlen($email) > 255) {
            $this->error = "This email is too long!";

            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error = "Invalid email";

            return false;
        }

        $this->email = $email;
        return true;
    }
    public function getError() {
        return $this->error;
    }
    public function getResult() {
        return $this->result;
    }
}