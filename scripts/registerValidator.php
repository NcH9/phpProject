<?
require_once __DIR__ . "/../db/User.php";

class registerValidator {
    
    public $imgError, $usernameError, $passwordError, $emailError, $birthDateError;
    private $image, $username, $password, $email, $birthDate, $admin;
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
        $username = trim($username);
        if (strlen($username) < 3) {
            $this->usernameError = "Username should be at least 3 symbols long";

            return false;
        } else if (strlen($username) > 20) {
            $this->usernameError = "Username should be not longer than 20 symbols";
            
            return false;
        }

        $user = new User();
        if ($user->getIfUsernameExists($username)) {
            $this->usernameError = "This username is already taken";

            return false;
        }

        $this->username = $username;
        return true;
    }
    private function validatePassword(string $password):bool {
        $password = trim($password);
        if (strlen($password) < 5) {
            $this->passwordError = "Password should be at least 5 symbols long";

            return false;
        } else if (strlen($password) > 20) {
            $this->passwordError = "Password should be not longer than 20 symbols";
            
            return false;
        }

        $this->password = $password;
        return true;
    }
    private function validateEmail(string $email):bool {
        $email = trim($email);
        $user = new User();

        if ($user->getIfEmailExists($email)) {
            $this->emailError = "This email is registered";

            return false;
        }

        if (strlen($email) > 255) {
            $this->emailError = "This email is too long!";

            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->emailError = "Invalid email";

            return false;
        }

        $this->email = $email;
        return true;
    }
    private function validateBirthday($birthDate):bool {
        $today = new DateTime();
        $birth = DateTime::createFromFormat('Y-m-d', $birthDate);

        if ($birthDate === null) {
            $this->birthDate = $birthDate;

            return true;
        }

        if ($birth > $today) {
            $this->birthDateError = "Enter correct date";

            return false;
        }

        $this->birthDate = $birthDate;
        return true;
    }
    public function validateAdmin(bool $admin):bool {
        $this->admin = $admin ? 1 : 0;

        return true;
    }
    private function validateImage($image):bool {
        // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // if (isset($_FILES['pfp'])) {
                // $image = $_FILES['pfp'];


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
            // }
        // }
    }
    private function addImage($image) {
        // $image = $_FILES['pfp'];
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


?>