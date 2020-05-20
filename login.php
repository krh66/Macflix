<?php
require_once("includes/config.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

    $account = new Account($con);

    if(isset($_POST["submitButton"])) {

        $userName = FormSanitizer::sanitizeFormUserName($_POST["userName"]);
        $password = FormSanitizer::sanitizeFormPassword($_POST["password"]);

        $success = $account->login($userName,$password);
     
        if($success){
            //Store session
            $_SESSION["userLoggedIn"] = $userName;
            header("Location: index.php"); // change location to another file.
        }
    }

    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Welcome to macflix!</title>
        <link rel= "stylesheet" type="text/css" href="assets/style/style.css" />
    </head>
    <body>
        <div class="signInContainer">

            <div class="column">

                <div class="header" style=" padding: 20px 0">
                    <img src="assets/images/logo.png" title="logo" alt="Site logo">
                    <h3>Sign In </h3>
                    <span> to continue to Macflix!</span>
                </div>

                <form method="POST">

                    <input type="text" name= "userName" placeholder="UserName" value= "<?php getInputValue("userName"); ?>" required>
                    <input type="password" name= "password" placeholder="Password" required>

                    <?php echo $account->getError(Constants::$loginFailed);?>

                    <input type="submit" name= "submitButton" value="SUBMIT">

                </form>

                <a href="register.php" class="signInMessage" > Need an account? Sign up here!</a>
            </div>

        </div>

    </body>

</html>