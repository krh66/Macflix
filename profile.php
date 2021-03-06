<?php
require_once("includes/header.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/Account.php");

$account = new Account($con);
$detailsMessage = "";


if(isset($_POST["saveDetailsButton"])) {

    $firstName = FormSanitizer::sanitizeFormString($_POST["firstName"]);
    $lastName = FormSanitizer::sanitizeFormString($_POST["lastName"]);
    $email = FormSanitizer::sanitizeFormEmail($_POST["email"]);

    if($account->updateDetails($firstName, $lastName, $email, $userLoggedIn)) {
        //success
        $detailsMessage = "<div class='alertSuccess'>
                            Details updated successfully
                            </div>";
    }
    else {
        //failure
        $errorMessage = $account->getFirstError();
        $detailsMessage = "<div class='alertError'>
                            $errorMessage
                           </div>";
    }
}

$passwordMessage = "";

if(isset($_POST["savePasswordButton"])) {

    $oldPassword = FormSanitizer::sanitizeFormPassword($_POST["oldPassword"]);
    $newPassword = FormSanitizer::sanitizeFormPassword($_POST["newPassword"]);
    $newPassword2 = FormSanitizer::sanitizeFormPassword($_POST["newPassword2"]);

    if($account->updatePassword($oldPassword, $newPassword, $newPassword2, $userLoggedIn)) {
        //success
        $passwordMessage = "<div class='alertSuccess'>
                            Password updated successfully
                            </div>";
    }
    else {
        //failure
        $errorMessage = $account->getFirstError();
        $passwordMessage = "<div class='alertError'>
                            $errorMessage
                           </div>";
    }
}

?>



<div class="settingsContainer column">

    <div class="formSection">

        <form method = "POST">

            <h2> User details</h2>

            <?php
            $user = new User($con, $userLoggedIn);

            $firstName = isset($_POST["firstName"]) ? $_POST["firstName"] : $user->getFirstName();
            $lastName = isset($_POST["lastName"]) ? $_POST["lastName"] : $user->getLastName();
            $email = isset($_POST["email"]) ? $_POST["email"] : $user->getEmail();
            ?>


            <input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName; ?>">
            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email; ?>">

            <div class="message" >
                <?php echo $detailsMessage; ?>
            </div>

            <input type="submit" name="saveDetailsButton" value="Save">

        </form>
    </div>

    <div class="formSection">

        <form method = "POST">

            <h2> Update password</h2>

            <input type="password" name="oldPassword" placeholder="Old password">
            <input type="password" name="newPassword" placeholder="New password">
            <input type="password" name="newPassword2" placeholder="Confirm new password">

            <div class="message" >
                <?php echo $passwordMessage; ?>
            </div>

            <input type="submit" name="savePasswordButton" value="Save"></input>

        </form>
    </div>

    <div class="formSection">
        <h2>Subscription</h2>

        <?php

        if($user->getIsSubscribed()) {
            echo "<h3>You are subscribed! Go to Paypal to cancel.</h3>";
        }else{
            echo "<a href='billing.php'> Subscribe to Macflix </a>";
        }
        ?>
    </div>

</div>