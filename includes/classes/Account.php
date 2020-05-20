<?php
class Account {

    private $con;
    private $errorArray = array();

    public function __construct($con) {
        $this->con = $con;
    }

    public function updateDetails($fn, $ln, $en, $un) {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateNewEmail($en, $un);

        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET firstName=:fn, lastName=:ln, email=:en
                                        WHERE username=:un");
            $query->bindValue(":fn", $fn);
            $query->bindValue(":ln", $ln);
            $query->bindValue(":en", $en);
            $query->bindValue(":un", $un);
            return $query->execute();

        }

        return false;
    }


    public function register($fn, $ln, $un, $en, $en2, $pw, $pw2){
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUserName($un);
        $this->validateEmail($en, $en2);
        $this->validPassword($pw, $pw2);

        if(empty($this->errorArray)){
            return $this->insertUserDetails($fn, $ln, $un, $en, $pw);
        }

        return false;
    }

    public function login($un, $pw){
        $pw = hash("sha512", $pw);

        $query = $this->con->prepare("SELECT * FROM users WHERE userName=:un AND password=:pw");
        $query->bindValue(":un", $un);
        $query->bindValue(":pw", $pw);

        $query->execute();
        
        if($query->rowCount() == 1){
            return true;
        }
        
        array_push($this->errorArray, Constants::$loginFailed);
        return false;

    }
    private function insertUserDetails($fn, $ln, $un, $en, $pw){

        $pw = hash("sha512", $pw);

        $query = $this->con->prepare("INSERT INTO users (firstName, lastName, userName, email, password)
                                        VALUES (:fn, :ln, :un, :en, :pw)");
        $query->bindValue(":fn", $fn);
        $query->bindValue(":ln", $ln);
        $query->bindValue(":un", $un);
        $query->bindValue(":en", $en);
        $query->bindValue(":pw", $pw);

        return $query->execute();
    }

    private function validateFirstName($fn){
        if(strlen($fn) < 2 || strlen($fn) > 25){
            array_push($this->errorArray, Constants::$firstNameCharacters);
        }
    }

    private function validateLastName($ln){
        if(strlen($ln) < 2 || strlen($ln) > 25){
            array_push($this->errorArray, Constants::$lastNameCharacters);
        }
    }

    private function validateUserName($un){
        if(strlen($un) < 2 || strlen($un) > 25){
            array_push($this->errorArray, Constants::$userNameCharacters);
            return;
        }

        $query = $this->con->prepare("SELECT * FROM users WHERE userName=:un");
        $query->bindValue(":un", $un);

        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errorArray, Constants::$userNameTaken);
        }
    }

    private function validateEmail($en, $en2){
        if($en != $en2){
            array_push($this->errorArray, Constants::$emailsDontMatch);
            return;
        }

        if(!filter_var($en, FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT * FROM users WHERE email=:en");
        $query->bindValue(":en", $en);

        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validateNewEmail($en, $un){

        if(!filter_var($en, FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }

        $query = $this->con->prepare("SELECT * FROM users WHERE email=:en AND username!= :un");
        $query->bindValue(":en", $en);
        $query->bindValue(":un", $un);

        $query->execute();

        if($query->rowCount() != 0){
            array_push($this->errorArray, Constants::$emailTaken);
        }
    }

    private function validPassword($pw, $pw2){
        if($pw != $pw2){
            array_push($this->errorArray, Constants::$passwordsDontMatch);
            return;
        }

        if(strlen($pw) < 5 || strlen($pw) > 25){
            array_push($this->errorArray, Constants::$passwordLength);
        }        

    }


    public function getError($error){
        if(in_array($error, $this->errorArray)){
            return "<span class='errorMessage'>$error</span>";
        }
    }

    public function getFirstError() {
        if(!empty($this->errorArray)) {
            return $this->errorArray[0];
        }
    }

    public function updatePassword($opw, $pw, $pw2, $un) {
        $this->validateOldPassowrd($opw, $un);
        $this->validPassword($pw, $pw2);

        $pw = hash("sha512", $pw);
        
        if(empty($this->errorArray)) {
            $query = $this->con->prepare("UPDATE users SET password=:pw WHERE username=:un");
            $query->bindValue(":pw", $pw);
            $query->bindValue(":un", $un);

            return $query->execute();
        }

        return false;

    }

    public function validateOldPassowrd($opw, $un) {
        $opw = hash("sha512", $opw);

        $query = $this->con->prepare("SELECT * FROM users WHERE userName=:un AND password=:opw");
        $query->bindValue(":un", $un);
        $query->bindValue(":opw", $opw);

        $query->execute();

        if($query->rowCount() == 0){
            array_push($this->errorArray, Constants::$passwordIncorrect);
        }
    }

}
?>