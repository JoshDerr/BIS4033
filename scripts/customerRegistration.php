<?php
    //access other files
    require_once '../app_config.php';
    require_once APP_ROOT.APP_FOLDER_NAME.'/scripts/echoHTML.php';
    require_once APP_ROOT.APP_FOLDER_NAME.'/scripts/errorDisplay.php'; 
    
    //define variables
    $fileTitle = 'Customer Registration';
    $jsTitle = APP_FOLDER_NAME.'/clientScripts/customerRegistration';
    $cssTitle = APP_FOLDER_NAME.'/styles/customerRegistration';

    function cleanIO($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return($data);
    }

    //get the data from the form
    if (isset($_POST['email'])) {
        $email = cleanIO($_POST['email']);
    }
    if (isset($_POST['password'])) {
        $password = cleanIO($_POST['password']);
    }
    if (isset($_POST['verified_password'])) {
        $verified_password = cleanIO($_POST['verified_password']);
    }
    if (isset($_POST['first_name'])) {
        $first_name = cleanIO($_POST['first_name']);
    }
    if (isset($_POST['state'])) {
        $state = cleanIO($_POST['state']);
    }
    if (isset($_POST['zip_code'])) {
        $zip_code = cleanIO($_POST['zip_code']);
    }
    if (isset($_POST['phone_number'])) {
        $phone_number = cleanIO($_POST['phone_number']);
    }
    if (isset($_POST['membership_types'])) {
        $membership_types = cleanIO($_POST['membership_types']);
    }
    if (isset($_POST['starting_date'])) {
        $starting_date = cleanIO($_POST['starting_date']);
    }

    //application specific checks:
    //check to make sure all fields are filled
    if(empty($email) || empty($password) || empty($verified_password) || empty($first_name) || empty($state) || empty($zip_code) || empty($phone_number) || empty($membership_types) || empty($starting_date)) {
        echoError("Too few arguements provided.", $fileTitle, $jsTitle, $cssTitle);
        exit();
    }
    //check to make sure passwords match
    if ($password != $verified_password) {
        echoError("Passwords must match.", $fileTitle, $jsTitle, $cssTitle);
        exit();
    }
    //check to make sure state id is two characters
    if (strlen($state) != 2) {
        echoError("Incorrect state ID format.", $fileTitle, $jsTitle, $cssTitle);
        exit();
    }
    //check to make sure zip is between five and nine characters
    if (!preg_match('/^\d{5}(-\d{4})?$/', $zip_code)) {
        echoError("Incorrect zip code format.", $fileTitle, $jsTitle, $cssTitle);
        exit();
    }
    //check to make sure phone number is twelve characters in total including dashes
    if (!preg_match('/[0-9]{3}-[0-9]{3}-[0-9]{4}/', $phone_number)) {
        echoError("Incorrect phone number format.", $fileTitle, $jsTitle, $cssTitle);
        exit();
    }
    //check to make sure membershuip type is gold, silver, or bronze
    if ($membership_types != "gold" && $membership_types != "silver" && $membership_types != "bronze"){
        echoError("Incorrect membership type format.", $fileTitle, $jsTitle, $cssTitle);
        exit();
    }

    //escape the unformatted input
    $email_escaped = htmlspecialchars($email);
    $password_escaped = htmlspecialchars($password);
    $verified_password_escaped = htmlspecialchars($verified_password);
    $first_name_escaped = htmlspecialchars($first_name);
    $state_escaped = htmlspecialchars($state);
    $zip_code_escaped = htmlspecialchars($zip_code);
    $phone_number_escaped = htmlspecialchars($phone_number);
    $membership_types_escaped = htmlspecialchars($membership_types);
    $starting_date_escaped = htmlspecialchars($starting_date);

    echoHead($fileTitle, $jsTitle, $cssTitle);
    echoHeader($fileTitle);

    echo '
        <fieldset>
            <legend>Your Response Has Been Sumbitted!</legend>

            <label>E-Mail:</label>
            <span>'.cleanIO($email_escaped).'</span><br>
            
            <label>Password:</label>
            <span>'.cleanIO($password_escaped).'</span><br>
                
            <label>First Name:</label>
            <span>'.cleanIO($first_name_escaped).'</span><br>
                
            <label>State:</label>
            <span>'.cleanIO($state_escaped).'</span><br>

            <label>ZIP Code:</label>
            <span>'.cleanIO($zip_code_escaped).'</span><br>

            <label>Phone Number:</label>
            <span>'.cleanIO($phone_number_escaped).'</span><br>

            <label>Membership Type:</label>
            <span>'.cleanIO($membership_types_escaped).'</span><br>

            <label>Starting Date:</label>
            <span>'.cleanIO($starting_date_escaped).'</span><br>
        </fieldset>
        ';

    echoFooter();
?>