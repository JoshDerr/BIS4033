<?php
function echoHead($jsFile, $cssFile){
echo'
<!DOCTYPE html>
    <html>
        <main>
            <body>
                <head>
                 <title>Customer Registration</title>
                    <script src = "' . $jsFile . '"></script>
                    <link rel="stylesheet" type="text/css" href="'. $cssFile .'">
                </head>
';
}

function echoHeader($title){
require_once('../app_config.php');
echo'

    <header>
        <h1>'.$title.'</h1>
    </header> 

<ul class="menu">
        <li><button a href="landingPage.php">Register New Patient</a></li>
        <li><button>Patients</button>
             <ul class="submenu"> 
                <li>Login</li>
                <li><a href="landingPage.php">Register</a></li>
                <li>Manage</li>
            </ul>
            <li>
            <form action="mailto: ast7198@utulsa.edu">
           <button type="submit">Email Us</button>
           </form>
       </li>
        <li><button>Log Out</button></li>
        <li><button></button></li>
    </ul>
    <br>
<br>
';
}

function echoFooter(){
    date_default_timezone_set('America/Chicago');
        $currDate = date('l jS \of F Y h:i:s A');
echo'
<footer>
    '.$currDate.' &copy; ACME Medical Group
</footer>
</html>
';
}


    ?>