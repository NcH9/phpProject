<?
namespace Palmo\scripts\Register\classes;
require_once __DIR__."/../interfaces/Validate1Reg.php";
use Palmo\scripts\Register\interfaces\Validate1Reg as Validate;
use Palmo\db\User;

class Password implements Validate {
    private $error, $result;
    public function __construct($password) {
        $this->result = $this->validate($password);
    }
    public function validate($password):bool {
        $password = trim($password);
        if (strlen($password) < 5) {
            $this->error = "Password should be at least 5 symbols long";

            return false;
        } else if (strlen($password) > 20) {
            $this->error = "Password should be not longer than 20 symbols";
            
            return false;
        }

        return true;
    }
    public function getError() {
        return $this->error;
    }
    public function getResult() {
        return $this->result;
    }
}