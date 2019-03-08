<!--register.php-->
<?php
include 'includes/config.php';
include 'includes/classes/Account.php';
include 'includes/classes/Constants.php';
$account = new Account($connection);
include 'includes/handlers/register-handler.php';
include 'includes/handlers/login-handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Spotify</title>
</head>
<body>
    <div id="inputContainer">
        <form id="loginForm" action="register.php" method="post">
            <h2>Login to your account</h2>
            <?php echo $account->get_error(Constants::INCORRECTLOGININFO); ?>
            <p>
                <label for="loginUsersname">Username</label>
                <input id="loginUsersname" value="<?php set_input_value('loginUsersname'); ?>" type="text" name="loginUsersname" placeholder="Eg. Dung Nguyen" required>
            </p>
            <p>
                <label for="loginPassword">Password</label>
                <input id="loginPassword" type="password" name="loginPassword" placeholder="Your password" required>
            </p>
            <button type="submit" name="loginButton">Log In</button>
        </form>

        <form id="registerForm" action="register.php" method="post">
            <h2>Create your free account</h2>
            <p>
                <label for="registerUsersname">Username</label>
                <input id="registerUsersname" value="<?php set_input_value('registerUsersname'); ?>" type="text" name="registerUsersname" placeholder="Eg. Dung Nguyen" required>
                <?php echo $account->get_error(Constants::INVALIDUSERNAMELENGTH); ?>
                <?php echo $account->get_error(Constants::INVALIDUSERNAME); ?>
            </p>
            <p>
                <label for="registerFirstname">Firstname</label>
                <input id="registerFirstname" value="<?php set_input_value('registerFirstname'); ?>" type="text" name="registerFirstname" placeholder="Eg. Dung" required>
                <?php echo $account->get_error(Constants::INVALIDFIRSTNAMELENGTH); ?>
            </p>
            <p>
                <label for="registerLastname">Lastname</label>
                <input id="registerLastname" value="<?php set_input_value('registerLastname'); ?>" type="text" name="registerLastname" placeholder="Eg. Nguyen" required>
                <?php echo $account->get_error(Constants::INVALIDLASTNAMELENGTH); ?>
            </p>
            <p>
                <label for="registerEmail">Email</label>
                <input id="registerEmail" value="<?php set_input_value('registerEmail'); ?>" type="email" name="registerEmail" placeholder="Eg. vietdung@yahoo.com" required>
                <?php echo $account->get_error(Constants::EMAILDONOTMATCH); ?>
                <?php echo $account->get_error(Constants::INVALIDEMAIL); ?>
                <?php echo $account->get_error(Constants::INVALIDUSEDEMAIL); ?>
            </p>
            <p>
                <label for="registerEmailConfirm">Confirm email</label>
                <input id="registerEmailConfirm" value="<?php set_input_value('registerEmailConfirm'); ?>" type="email" name="registerEmailConfirm" placeholder="Eg. vietdung@yahoo.com" required>
            </p>
            <p>
                <label for="registerPassword">Password</label>
                <input id="registerPassword" type="password" name="registerPassword" placeholder="Your password" required>
                <?php echo $account->get_error(Constants::PASSWORDDONOTMATCH); ?>
                <?php echo $account->get_error(Constants::INVALIDPASSWORD); ?>
                <?php echo $account->get_error(Constants::INVALIDPASSWORDLENGTH); ?>
            </p>
            <p>
                <label for="registerPasswordConfirm">Confirm password</label>
                <input id="registerPasswordConfirm" type="password" name="registerPasswordConfirm" placeholder="Your password" required>
            </p>
            <button type="submit" name="registerButton">Sign Up</button>
        </form>
    </div>
</body>
</html>