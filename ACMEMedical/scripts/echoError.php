<?php
function echoError($errMsg){
    require_once('../app_config.php');
    require_once(APP_ROOT.APP_FOLDER_NAME.'/scripts/echoHTML.php');
    echoHead(APP_FOLDER_NAME.'/clientScripts/customerRegistration.js', APP_FOLDER_NAME.'/styles/customerRegistration.css');
    echoHeader("There is an Error");
    echo"<h3>$errMsg</h3>";
    echoFooter(); 
}
?>