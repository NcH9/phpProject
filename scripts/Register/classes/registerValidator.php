<?
namespace Palmo\scripts\Register\classes;
require_once __DIR__ . "/../../../db/User.php";
require_once __DIR__."/Username.php";
require_once __DIR__."/Password.php";
require_once __DIR__."/Email.php";
require_once __DIR__."/Birthday.php";
use Palmo\db\User;
use Palmo\scripts\Register\classes\Username;
use Palmo\scripts\Register\classes\Password;
use Palmo\scripts\Register\classes\Email;
use Palmo\scripts\Register\classes\Birthday;




class registerValidator {
    
    public $imgError, $usernameError, $passwordError, $emailError, $birthDateError;
    public $image;
    private $username, $password, $email, $birthDate, $admin;
    private function validateAll($username, $password, $email, $birthDate, $admin, $image):bool {
        $usernameBool = $this->validateUsername($username);
        $passwordBool = $this->validatePassword($password);
        $emailBool = $this->validateEmail($email);
        $birthDateBool = $this->validateBirthday($birthDate);
        $adminBool = $this->validateAdmin($admin);
        $imageBool = $this->validateImage($image);

        if ($usernameBool && $passwordBool && $emailBool && $birthDateBool && $adminBool && $imageBool) {

            return true;
        }

        return false;
    }
    private function validateUsername(string $username):bool {
        $validator = new Username($username);
        if ($validator->getResult()) {
            $this->username = $username;
            
            return true;
        }

        $this->usernameError = $validator->getError();
        return false;
    }
    private function validatePassword(string $password):bool {
        $validator = new Password($password);
        if ($validator->getResult()) {
            $this->password = $password;

            return true;
        }

        $this->passwordError = $validator->getError();
        return false;
    }
    private function validateEmail(string $email):bool {
        $validator = new Email($email);
        if ($validator->getResult()) {
            $this->email = $email;

            return true;
        }

        $this->emailError = $validator->getError();
        return false;
    }
    private function validateBirthday($birthdate):bool {
        $validator = new Birthday($birthdate);
        if ($validator->getResult()) {
            $this->birthDate = $birthdate;

            return true;
        }

        $this->birthDateError = $validator->getError();
        return false;
    }
    public function validateAdmin(bool $admin):bool {
        $this->admin = $admin ? 1 : 0;

        return true;
    }
    public function validateImage($image):bool {
        if ($image === null) {
            $this->image = $image;

            return true;
        }


        if (is_string($image)) {
            if (trim($image) == "") {
                $this->image = null;

                return true;
            }
        }
        

        if ($image['size'] > 2097152) {
            $this->imgError = "The file is too big";

            return false;
        }

        $this->image = $image;
        return true;
    }
    public function addImage($image) {
        if ($image !== null) {
            $targetFile = "../images/" . basename($image['name']);

            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                $this->image = $targetFile;
            } else {
                echo "Error loading picture...";
            }
        } 
    }
    public function registerSubmit($username, $password, $email, $birthDate, $admin, $image):bool {
        if ($this->validateAll($username, $password, $email, $birthDate, $admin, $image)) {
            $this->addImage($this->image);
            $user = new User();
            $user->addUser(
                $this->username,
                $this->password,
                $this->email,
                $this->birthDate,
                $this->admin,
                $this->image
            );

            return true;
        } 

        return false;
    }
}