<!--register-handler.php-->
<?php

//****************************************************define functions *************************************************
//For both register and login handlers
/**
 * Strip HTML tags from input and replace " " with ""
 *
 * @param $input Form input
 * @return mixed Sanitized String
 */
function sanitize_input($input){
    return str_replace(" ", "", strip_tags($input));
}

/**
 * Strip HTML tags from input, replace " " with "" and make first character uppercase
 *
 * @param $input
 * @return string Sanitized String with first character is uppercase
 */
function sanitize_input_ucfirst($input){
    return ucfirst(strtolower(sanitize_input($input)));
}

/**
 * Strip HTML tags from password
 *
 * @param $password Form password
 * @return mixed Sanitized password
 */
function sanitize_password($password){
    return strip_tags($password);
}

/**
 * Setup register data
 *
 * @return mixed Register data
 */
function setup_register_data(){
    $registerData['registerUsersname'] = sanitize_input($_POST['registerUsersname']);
    $registerData['registerFirstname'] = sanitize_input_ucfirst($_POST['registerFirstname']);
    $registerData['registerLastname'] = sanitize_input_ucfirst($_POST['registerLastname']);
    $registerData['registerEmail'] = sanitize_input($_POST['registerEmail']);
    $registerData['registerEmailConfirm'] = sanitize_input($_POST['registerEmailConfirm']);
    $registerData['registerPassword'] = sanitize_password($_POST['registerPassword']);
    $registerData['registerPasswordConfirm'] = sanitize_password($_POST['registerPasswordConfirm']);
    return $registerData;
}

/**
 * Get and set input value from previous request if error in input tag
 *
 * @param $inputName
 */
function set_input_value($inputName){
    echo isset($_POST[$inputName]) ? $_POST[$inputName] : null;
}

//****************************************************define functions end**********************************************

//****************************************************Handler start*****************************************************
if(isset($_POST['registerButton'])){
    //Register form submitted
    $registerData = setup_register_data();
    $wasSuccess = $account->register($registerData);
    if($wasSuccess){
        header('Location: index.php');
    }
}

//****************************************************Handler end*******************************************************