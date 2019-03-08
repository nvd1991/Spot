<!--Account.php class-->
<?php

/**
 * Account class contains account info
 *
 * Class Account
 */
class Account {
    private $errorArray;

    /**
     * Account constructor.
     */
    public function __construct()
    {
        $this->errorArray = [];

    }

    /**
     * Register an account
     *
     * @param $registerData
     * @return bool
     */
    public function register($registerData){
        $this->validate_register_data($registerData);
        if(empty($this->errorArray)){
            //Insert into DB
            return true;
        } else {
            return false;
        }
    }

    public function get_error($error){
        if(!in_array($error, $this->errorArray)){
            $error = '';
        }
        return "<span class='errorMessage'>$error</span>";
    }

    /**
     * Validate register username
     *
     * @param $registerUsername
     */
    private function validate_register_username($registerUsername){
        if( strlen($registerUsername) > 25 || strlen($registerUsername) < 5){
            array_push($this->errorArray, Constants::INVALIDUSERNAMELENGTH);
            return;
        }

        //TODO: check if username exist
    }

    /**
     * Validate register firstname
     *
     * @param $registerFirstname
     */
    private function validate_register_firstname($registerFirstname){
        if( strlen($registerFirstname) > 25 || strlen($registerFirstname) < 2){
            array_push($this->errorArray, Constants::INVALIDFIRSTNAMELENGTH);
            return;
        }
    }

    /**
     * Validate register lastname
     *
     * @param $registerLastname
     */
    private function validate_register_lastname($registerLastname){
        if( strlen($registerLastname) > 25 || strlen($registerLastname) < 2){
            array_push($this->errorArray, Constants::INVALIDLASTNAMELENGTH);
            return;
        }
    }


    /**
     * Validate register emails
     *
     * @param $registerEmail
     * @param $registerEmailConfirm
     */
    private function validate_register_email($registerEmail, $registerEmailConfirm){
        if($registerEmail != $registerEmailConfirm){
            array_push($this->errorArray, Constants::EMAILDONOTMATCH);
            return;
        }

        if(!filter_var($registerEmail, FILTER_VALIDATE_EMAIL)){
            array_push($this->errorArray, Constants::INVALIDEMAIL);
            return;
        }

        //TODO: check if email exist
    }

    /**
     * Validate register passwords
     *
     * @param $registerPassword
     * @param $registerPasswordConfirm
     */
    private function validate_register_password($registerPassword, $registerPasswordConfirm){
        if($registerPassword != $registerPasswordConfirm){
            array_push($this->errorArray, Constants::PASSWORDDONOTMATCH);
            return;
        }

        if(preg_match('/[^A-Za-z0-9]/', $registerPassword)){
            array_push($this->errorArray, Constants::INVALIDPASSWORD);
            return;
        }

        if( strlen($registerPassword) > 30 || strlen($registerPassword) < 5){
            array_push($this->errorArray, Constants::INVALIDPASSWORDLENGTH);
            return;
        }
    }

    /**
     * Validate register data
     *
     * @param $registerData
     */
    private function validate_register_data($registerData){
        $this->validate_register_username($registerData['registerUsersname']);
        $this->validate_register_firstname($registerData['registerFirstname']);
        $this->validate_register_lastname($registerData['registerLastname']);
        $this->validate_register_email($registerData['registerEmail'], $registerData['registerEmailConfirm']);
        $this->validate_register_password($registerData['registerPassword'], $registerData['registerPasswordConfirm']);
    }
}