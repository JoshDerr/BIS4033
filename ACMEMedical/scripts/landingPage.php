<?php
require_once('../app_config.php');
require_once(APP_ROOT.APP_FOLDER_NAME.'/scripts/echoHTML.php');
echoHead("../clientScripts/customerRegistration.js", "../styles/patientRegistration.css");
echoHeader("ACME Medical Patient Portal");
echo '

    <form action="medicationRegistration.php" method="post">  
    <fieldset>
            <legend>General Patient Information:</legend>
                    <label>First Name:</label>
                        <input type="text" name="first_name" id="first_name" placeholder="required" required><br>

                    <label>Last Name:</label>
                        <input type="text" name="last_name" id="last_name" placeholder="required" required><br>
                    
                    <label>Gender:</label>
                    <select name="patientGender" id="patientGender">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="OPNTA">Other; Prefer not to answer</option>
                    </select><br>

                    <label>Date of Birth:</label>
                        <input type="date" name="patientDOB" id="patientDOB"  required><br>
                    
                    <label>Genetics:</label>
                        <input type="text" name="patientGenetics" id="patientGenetics" placeholder="if none; answer N/A" required><br>
                    
                    <label>Diabetes:</label>
                        <select name="dmStatus" id="dmStatus">
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                        </select><br>

                    <label>Other Conditions:</label>
                        <input type="text" name="otherConditions" id="otherConditions" placeholder="if none; answer N/A" required><br>
            </fieldset>
            <br>
            
            <fieldset>
                <legend>Continue to Medication Registration:</legend>

                <div id="buttons" data-inline="true">
                <input type="submit" value="Next Step >" data-inline="true">
                <input type="reset" value="Reset Fields" data-inline="true"><br> 

                </div>
            </fieldset>   
            <br>
';
echoFooter();

                  

    ?>