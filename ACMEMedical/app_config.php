<?php 
//application folder name on your web root or htdocs folder
define('APP_ROOT',$_SERVER['DOCUMENT_ROOT']);
//DEBUG echo (APP_ROOT);
define('APP_FOLDER_NAME', '/BIS4033/ACMEMedical');
define('WEB_ROOT','http://'.$_SERVER['SERVER_NAME']);
//DEBUG echo(WEB_ROOT). '<br>'; exit();
define('DSN1', 'mysql:host=localhost;dbname=mycustomers');
define('USER1', 'kermit');
define('PASSWD1', 'sesame');
?>