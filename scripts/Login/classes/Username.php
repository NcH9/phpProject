<?
namespace Palmo\scripts\Login\classes;
require_once __DIR__."/../interfaces/Validate1Log.php";
use Palmo\scripts\Login\interfaces\Validate1Log as Validate;
use Palmo\db\User;
class Username implements Validate {
    public static function validate($username): bool {
        if (strlen(trim($username)) < 3) {

            return false;
        }

        $user = new User();
        if ($user->getIfUsernameExists($username)) {
            // $this->username = $usernameToCheck;

            return true;
        }

        return false;
    }
}