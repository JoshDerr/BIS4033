<?php
    function echoError($errorMessage, $fileTitle, $jsTitle, $cssTitle) {
        require_once '../app_config.php';
        require_once APP_ROOT.APP_FOLDER_NAME.'/scripts/echoHTML.php';
        
        echoHead($fileTitle, $jsTitle, $cssTitle);
        echoHeader('Error: Please go back and try again');
        
        echo "<h3>".$errorMessage."</h3>";
        
        echoFooter();
        
        exit();
    }//echoError()
?>