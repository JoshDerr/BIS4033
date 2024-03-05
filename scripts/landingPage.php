<?php
require_once '../app_config.php';
require_once APP_ROOT.APP_FOLDER_NAME.'/scripts/echoHTML.php'; 

echoHead("Customer Registration", APP_FOLDER_NAME."/clientScripts/customerRegistration", APP_FOLDER_NAME."/styles/customerRegistration");
echoHeader("Customer Registration");

echo '
    <form name = "myForm" action = "customerRegistration.php" onsubmit = "validatePassword();" method="post">    

        <fieldset>
            <legend>Registration Information</legend>
        
            <label>E-Mail:</label>
            <input type = "email" id = "email" name = "email" required><br>
                
            <label>Password:</label>
            <input type = "password" id = "password" name = "password" placeholder = "At least 6 letters or numbers" pattern = "[a-zA-Z0-9]{6,}"><br>

            <label>Verify Password:</label>
            <input type = "password" id = "verified_password" name = "verified_password" pattern = "[a-zA-Z0-9]{6,}"><br>
        </fieldset><br>

        <fieldset>
            <legend>Member Information</legend>

            <label>First Name:</label>
            <input type = "text" id = "first_name" name = "first_name" required><br>

            <label>State:</label>
            <input type = "text" id = "state" name = "state" placeholder = "2-character code" pattern="[A-Za-z]{2}" maxlength = "2" required><br>

            <label>ZIP Code:</label>
            <input type = "text" id = "zip_code" name = "zip_code" placeholder = "5 or 9 digits" pattern = "^\d{5}(-\d{4})?$" required><br>

            <label>Phone Number:</label>
            <input type = "tel" id = "phone_number" name = "phone_number" placeholder = "999-999-9999" pattern = "[0-9]{3}-[0-9]{3}-[0-9]{4}" required><br>
        </fieldset><br>

        <fieldset>
            <legend>Membership Information</legend>

            <label>Membership Type:</label>
            <select name = "membership_types" id = "membership_types" required>
                <option value = "gold">Gold</option>
                <option value = "silver">Silver</option>
                <option value = "bronze">Bronze</option>
            </select><br>

            <label>Starting Date:</label>
            <input type = "date" id = "starting_date" name = "starting_date" required>
        </fieldset><br>

        <fieldset>
            <legend>Submit Your Membership</legend>

            <div id = "buttons">
                <button type = "submit" class = "submit">Submit</button>
                <button type = "reset" class = "reset">Reset Fields</button>
            </div>
        </fieldset>
    </form>';

echoFooter();
?>