<?php
require_once('../app_config.php');
require_once(APP_ROOT.APP_FOLDER_NAME.'/scripts/echoHTML.php');
echoHead("../clientScripts/customerRegistration.js", "../styles/patientRegistration.css");
echoHeader("ACME Medical Patient Portal");
echo '
<form action="enzymeRegistration.php" method="post">  
    <fieldset>
            <fieldset>
            <legend>Medication Information</legend>

                <label>Vest Use:</label>
                <select name="vestUse" id="vestUse">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select><br>

                <label>Acapella Inhaler Usage (Acapella DM or Acapella DH):</label>
                <select name="acapellaUse" id="acapellaUse">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select><br>

                <label>Plumazyme Usage:</label>
                <select name="plumazymeUse" id="plumazymeUse">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select><br>

                <label>Plumazyme Usage (if applicable):</label>
                <input type="text" name="plumazymeQuantity" id="plumazymeQuantity" placeholder="Enter Dosage"><br>

                <label>Date of Plumazyme Treatment (if applicable):</label>
                <input type="date" name="plumazymeDate" id="plumazymeDate" ><br>

                <label>TOBI Inhalation Treatment:</label>
                <select name="tobiUse" id="tobiUse">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select><br>

                <label>Hypertonic Saline Usage:</label>
                <select name="hsUse" id="hsUse">
                    <option value="Yes 3%">Yes 3%</option>
                    <option value="Yes 7%">Yes 7%</option>
                    <option value="no">No Hypertonic Saline Usage</option>
                </select><br>

                <label>Aithromycin Usage:</label>
                <select name="zpackUse" id="zpackUse">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select><br>

                <label>Clarithromycin (BIAXIN) Usage:</label>
                <select name="biaxinUse" id="biaxinUse">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select><br>

                <label>Gentamicin Usage:</label>
                <select name="garamicinUse" id="garamicinUse">
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select><br>
            </fieldset>
            <br>

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
                <legend>Continue to Enzyme Registration:</legend>

                <div id="buttons" data-inline="true">
                <input type="submit" value="Submit" data-inline="true">
                <input type="reset" value="Reset Fields" data-inline="true"><br> 

                </div>
            </fieldset>   
            <br>
';
echoFooter();

                  

    ?>