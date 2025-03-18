<?
namespace Palmo\scripts\Register\classes;
require_once __DIR__."/../interfaces/Validate1Reg.php";
use Palmo\scripts\Register\interfaces\Validate1Reg as Validate;
use Palmo\db\User;
use DateTime;

class Birthday implements Validate {
    private $error, $result;
    public function __construct($birthdate) {
        $this->result = $this->validate($birthdate);
    }
    public function validate($birthdate):bool {
        $today = new DateTime();
        $birth = DateTime::createFromFormat('Y-m-d', $birthdate);

        if ($birthdate === null) {

            return true;
        }

        if ($birth > $today) {
            $this->birthDateError = "Enter correct date";

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