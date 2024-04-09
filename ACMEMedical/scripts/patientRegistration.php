<?php
require_once('../app_config.php');
require_once(APP_ROOT. APP_FOLDER_NAME.'/scripts/echoHTML.php');
require_once(APP_ROOT. APP_FOLDER_NAME.'/scripts/utilities.php');
require_once(APP_ROOT . APP_FOLDER_NAME.'/scripts/echoError.php');
$myJSFile = APP_FOLDER_NAME . '/clientScripts/patientRegistration.js';
$myCSSFile = APP_FOLDER_NAME . '/styles/patientRegistration.css'; 

//Gets data from the form 

if (isset($_POST['cust_email'])){
    $cust_email = cleanIO($_POST['cust_email']);
}

if (isset($_POST['password'])){
        $password = cleanIO($_POST['password']);
}

if (isset($_POST['verify_password'])){
        $verifyPassword = cleanIO($_POST['verify_password']);
}

if (isset($_POST['first_name'])){
        $first_name = cleanIO($_POST['first_name']);
}

if (isset($_POST['state_code'])){
        $state_code = cleanIO($_POST['state_code']);
}

if (isset($_POST['zip_code'])){
        $zip_code = cleanIO($_POST['zip_code']);
}

if (isset($_POST['phone_number'])){
        $phone_number = cleanIO($_POST['phone_number']);
}

if (isset($_POST['type'])){
        $type = cleanIO($_POST['type']);
}

if (isset($_POST['date'])){
        $date = cleanIO($_POST['date']);
}

//Checks the app

if ($cust_email == ""){
    echoError("Input the Correct Email");
    exit();
}

if ($password == ""){
    echoError("Enter Your Password");
    exit();
}

if ($verifyPassword == ""){
    echoError("Please Verify Your Password");
    exit();
}

if ($first_name == ""){
    echoError("Give Your First Name");
    exit();
}

if ($state_code == ""){
    echoError("Correct Your State Code");
    exit();
}

if ($zip_code == ""){
    echoError("Correct Your Zip Code");
    exit();
}

if ($phone_number == ""){
    echoError("Correct Your Phone Number");
    exit();
}

if ($type == ""){
    echoError("Choose The Type");
    exit();
}

if ($date == ""){
    echoError("Correct Your Start Date");
    exit();
}

if($password !== $verifyPassword){
    echoError("Passwords are not matching");
    exit();
}

// encrypted password
$encryptedPassword = md5($password);

//inserting new row into the database
require_once(APP_ROOT.APP_FOLDER_NAME. '/scripts/DbConnection.php');
$myDB = getDB(DSN1, USER1, PASSWD1);
$insertStmt = "INSERT INTO customers_main (email, password, first_name, state, zip, phone, membership_type, starting_date)
VALUES (:custEmail, :custPassword, :custName, :custState, :custZip, :custPhone, :custMembershipType, :custStartingDate)";
try {
    $stmt = $myDB -> prepare($insertStmt);
    $stmt -> bindValue(':custEmail', $cust_email);
    $stmt -> bindValue(':custPassword', $encryptedPassword);
    $stmt -> bindValue(':custName', $first_name);
    $stmt -> bindValue(':custState', $state_code);
    $stmt -> bindValue(':custZip', $zip_code);
    $stmt -> bindValue(':custPhone', $phone_number);
    $stmt -> bindValue(':custMembershipType', $type);
    $stmt -> bindValue(':custStartingDate', $date);
    $stmt -> execute();
    $stmt -> closeCursor();
} catch (Exception $e) {
    echoError($e -> getMessage());
    exit(1);
}

echoHead(APP_FOLDER_NAME.'/clientScripts/customerRegistration.js', APP_FOLDER_NAME.'/styles/customerRegistration.css');
echoHeader("Customer Registration");
echo '
        <fieldset>
            <legend>Registration Information:</legend>
                <label>Email:</label>
                <span>' . cleanIO($cust_email) . '</span><br>
        </fieldset>
        <br>
        
        <fieldset>
            <legend>Member Information:</legend>
                <label>First Name:</label>
                <span>'.  cleanIO($first_name) .'</span><br>

                <label>State:</label>
                <span>'. cleanIO($state_code) .'</span><br>

                <label>Zip Code:</label>
                <span>'. cleanIO($zip_code) .'</span><br>

                <label>Phone Number:</label>
                <span>'. cleanIO($phone_number) .'</span><br>

        </fieldset>
        <br>
        
        <fieldset>
            <legend>Membership Information:</legend>
                <label>Membership Type:</label>
                <span>'. cleanIO($type) .'</span><br>

                <label>Start Date:</label>
                <span>'. cleanIO($date) .'</span><br>

        </fieldset>
        <br>
';
echoFooter();
?>
    


