<?
namespace Palmo\scripts\Login\classes;
require_once __DIR__."/../interfaces/Validate2Log.php";
require_once __DIR__."/../../../db/User.php";
use Palmo\scripts\Login\interfaces\Validate2Log as Validate;
use Palmo\db\User as dbUser;
class User implements Validate {
    // public $user;
    public static function validate($username, $password) {
        if (strlen(trim($username)) < 3 || strlen(trim($password)) < 5) {

            return false;
        }

        $user = new dbUser();
        $user = $user->fetchUserByCredentials($username, $password);

        if ($user !== false) {          
            // $this->user = $user;

            return $user;
        }

        return false;
    }
}