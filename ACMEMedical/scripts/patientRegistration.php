<?php
require_once('../app_config.php');
require_once(APP_ROOT. APP_FOLDER_NAME.'/scripts/echoHTML.php');
require_once(APP_ROOT. APP_FOLDER_NAME.'/scripts/utilities.php');
require_once(APP_ROOT . APP_FOLDER_NAME.'/scripts/echoError.php');
$myJSFile = APP_FOLDER_NAME . '/clientScripts/patientRegistration.js';
$myCSSFile = APP_FOLDER_NAME . '/styles/patientRegistration.css'; 

//Gets data from the form 

if (isset($_POST['first_name'])){
    $first_name = cleanIO($_POST['first_name']);
}

if (isset($_POST['last_name'])){
        $last_name = cleanIO($_POST['last_name']);
}

if (isset($_POST['patientGender'])){
        $patientGender = cleanIO($_POST['patientGender']);
}

if (isset($_POST['patientDOB'])){
        $patientDOB = cleanIO($_POST['patientDOB']);
}

if (isset($_POST['patientGenetics'])){
        $patientGenetics = cleanIO($_POST['patientGenetics']);
}

if (isset($_POST['dmStatus'])){
        $dmStatus = cleanIO($_POST['dmStatus']);
}

if (isset($_POST['vestUse'])){
        $vestUse = cleanIO($_POST['vestUse']);
}

if (isset($_POST['acapellaUse'])){
        $acapellaUse = cleanIO($_POST['acapellaUse']);
}

if (isset($_POST['plumazymeUse'])){
        $plumazymeUse = cleanIO($_POST['plumazymeUse']);
}

if (isset($_POST['plumazymeQuantity'])){
    $plumazymeQuantity = cleanIO($_POST['plumazymeQuantity']);
}

if (isset($_POST['plumazymeDate'])){
    $plumazymeDate = cleanIO($_POST['plumazymeDate']);
}

if (isset($_POST['tobiUse'])){
    $tobiUse = cleanIO($_POST['tobiUse']);
}

if (isset($_POST['hsUse'])){
    $hsUse = cleanIO($_POST['hsUse']);
}

if (isset($_POST['zpackUse'])){
    $zpackUse = cleanIO($_POST['zpackUse']);
}

if (isset($_POST['biaxinUse'])){
    $biaxinUse = cleanIO($_POST['biaxinUse']);
}

if (isset($_POST['garamicinUse'])){
    $garamicinUse = cleanIO($_POST['garamicinUse']);
}

if (isset($_POST['enzymeUse'])){
    $enzymeUse = cleanIO($_POST['enzymeUse']);
}

if (isset($_POST['enyzmeType'])){
    $enyzmeType = cleanIO($_POST['enyzmeType']);
}

if (isset($_POST['enzymeDosage'])){
    $enzymeDosage = cleanIO($_POST['enzymeDosage']);
}

if (isset($_POST['visitDate'])){
    $visitDate = cleanIO($_POST['visitDate']);
}

if (isset($_POST['providerName'])){
    $providerName = cleanIO($_POST['providerName']);
}

if (isset($_POST['testDate'])){
    $testDate = cleanIO($_POST['testDate']);
}

if (isset($_POST['testingValue'])){
    $testingValue = cleanIO($_POST['testingValue']);
}

if (isset($_POST['colistinUse'])){
    $colistinUse = cleanIO($_POST['colistinUse']);
}



//Checks the app

if ($first_name == ""){
    echoError("Enter your First Name");
    exit();
}

if ($last_name == ""){
    echoError("Enter Your Last Name");
    exit();
}

if ($patientGender == ""){
    echoError("Please Enter your Gender");
    exit();
}

if ($patientDOB == ""){
    echoError("Enter your Birth Date");
    exit();
}

if ($patientGenetics == ""){
    echoError("Please apply field with genetics");
    exit();
}

if ($dmStatus == ""){
    echoError("Click yes or no for: Diabetes");
    exit();
}

if ($vestUse == ""){
    echoError("Click yes or no for medication: Vest");
    exit();
}

if ($acapellaUse == ""){
    echoError("Click yes or no for medication: Acapella");
    exit();
}

if ($plumazymeUse == ""){
    echoError("Click yes or no for medication: Plumozyme");
    exit();
}

if ($plumazymeQuantity == ""){
    echoError("Correct Your Dosage of Plumozyme");
    exit();
}

if ($plumazymeDate == ""){
    echoError("Correct Your date of Plumozyme");
    exit();
}

if ($tobiUse == ""){
    echoError("Click yes or no for medication: Inhaled Tobi");
    exit();
}

if ($hsUse == ""){
    echoError("Correct the amount of medication: Hypertonic Saline Usage");
    exit();
}

if ($zpackUse == ""){
    echoError("Click yes or no for medication: Aithromycin");
    exit();
}

if ($colistinUse == ""){
    echoError("Click yes or no for medication: COLISTIN Inhalation Treatment");
    exit();
}

if ($biaxinUse == ""){
    echoError("Click yes or no for medication: Clarithromycin (BIAXIN)");
    exit();
}

if ($garamicinUse == ""){
    echoError("Click yes or no for medication: Gentamicin");
    exit();
}

if ($enzymeUse == ""){
    echoError("Click yes or no for medication: Enyzymes");
    exit();
}

if ($enzymeType == ""){
    echoError("Correct the enzyme type");
    exit();
}

if ($enzymeDosage == ""){
    echoError("Correct the enzyme dosage");
    exit();
}

if ($visitDate == ""){
    echoError("Correct the visit date");
    exit();
}

if ($providerName == ""){
    echoError("Correct the provider name");
    exit();
}

if ($testDate == ""){
    echoError("Correct the test date");
    exit();
}

if ($testingValue == ""){
    echoError("Correct the testing value");
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
    


