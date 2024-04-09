<?php
require_once('../app_config.php');
require_once(APP_ROOT.APP_FOLDER_NAME.'/scripts/echoHTML.php');
echoHead("../clientScripts/customerRegistration.js", "../styles/patientRegistration.css");
echoHeader("ACME Medical Patient Portal");
echo '
<form action="enzymeRegistration.php" method="post">  
    <fieldset>
            <fieldset>
            <legend>Enzymes Report</legend>
                <label>Enyzymes:</label>
                <select name="enzymeUse" id="enzymeUse">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select><br>

                <label>Enzyme Type:</label>
                <input type="text" name="enzymeType" id="enyzmeType" placeholder="Enter Type"><br>

                <label>Enzyme Dosage:</label>
                <input type="text" name="enzymeDosage" id="enyzmeDosage" placeholder="Enter Enzyme Dosage"><br>                
            </fieldset>

            <fieldset>
                <legend>Doctor Visit</legend>

                <label>Date of Visit:</label>
                <input type="date" name="visitDate" id="visitDate"  required><br>

                <label>Provider Seen:</label>
                <input type="text" name="providerName" id="providerName" required><br>
            </fieldset>
            
            <fieldset>
                <legend>FEV-1 lung testing</legend>
                <label>Date of Test:</label>
                <input type="date" name="testDate" id="testDate"  required><br>
                
                <label>FEV-1 Testing Value:</label>
                <input type="text" name="testingValue" id="testingValue" required><br>

            </fieldset>
            
            <fieldset>
                <legend>Submit Patient Information:</legend>

                <div id="buttons" data-inline="true">
                <input type="submit" value="Submit" data-inline="true">
                <input type="reset" value="Reset Fields" data-inline="true"><br> 

                </div>
            </fieldset>   
            <br>
';
echoFooter();

                  

    ?>