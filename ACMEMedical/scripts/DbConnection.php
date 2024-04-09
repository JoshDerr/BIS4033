<?php
function getDB($dsn, $userName, $passwd) {
  require_once('../app_config.php');
  require_once(APP_ROOT.APP_FOLDER_NAME.'/scripts/echoError.php');
  try {
    //DEBUG echo $dsn;
    $db = new PDO($dsn, $userName, $passwd);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo 'Successful connection to database';
    return $db;
  } catch (Exception $e) {
    echoError($e -> getMessage());
    exit(1);
  } //try-catch
} //getDB
?>