<!--Account.php class-->
<?php

/**
 * Account class contains account info
 *
 * Class Account
 */
class Account {
    private $errorArray;
    private $connection;

    /**
     * Account constructor.
     * @param $connection
     */
    public function __construct($connection)
    {
        $this->errorArray = [];
        $this->connection = $connection;
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
            if($this->insert_user_detail($registerData)){
                return true;
            }
        }
        return false;
    }

    /**
     * Log in
     *
     * @param $loginData
     * @return bool
     */
    public function login($loginData){
        $loginUsersname = $loginData['loginUsersname'];
        $sql = "select username, password from users where username = '$loginUsersname'";
        echo $sql;
        $result = mysqli_query($this->connection, $sql);
        if(mysqli_num_rows($result)){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($loginData['loginPassword'], $row['password'])){
                return true;
            }
        }
        array_push($this->errorArray, Constants::INCORRECTLOGININFO);
        return false;
    }

    /**
     * Return validate error message
     *
     * @param $error
     * @return string
     */
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
        $sql = "select username as count from users where username = '$registerUsername'";
        $result = mysqli_query($this->connection, $sql);
        if(mysqli_num_rows($result)){
            array_push($this->errorArray, Constants::INVALIDUSERNAME);
            return;
        }
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
        $sql = "select email as count from users where email = '$registerEmail'";
        $result = mysqli_query($this->connection, $sql);
        if(mysqli_num_rows($result)){
            array_push($this->errorArray, Constants::INVALIDUSEDEMAIL);
            return;
        }
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

    /**
     * Insert user detail into database
     *
     * @param $registerData
     * @return bool|mysqli_result
     */
    private function insert_user_detail($registerData){
        //escape input for sql insert
        $registerUsername = mysqli_real_escape_string($this->connection, $registerData['registerUsersname']);
        $registerFirstname = mysqli_real_escape_string($this->connection, $registerData['registerFirstname']);
        $registerLastname = mysqli_real_escape_string($this->connection, $registerData['registerLastname']);
        $registerEmail = mysqli_real_escape_string($this->connection, $registerData['registerEmail']);
        $registerPassword = mysqli_real_escape_string($this->connection, $registerData['registerPassword']);

        //encrypt password, update current time and set default profile picture
        $encryptedPassword = password_hash($registerPassword, PASSWORD_BCRYPT);
        $registerCreatedAt = date('Y-m-d H:i:s');
        $registerProfilePicture = 'assets/images/profile-pics/default.png';

        //insert user detail
        $sql = "insert into users(username, firstname, lastname, email, password, created_at, profile_picture) values ('$registerUsername', '$registerFirstname', '$registerLastname', '$registerEmail', '$encryptedPassword', '$registerCreatedAt', '$registerProfilePicture')";
        return mysqli_query($this->connection, $sql);
    }
}