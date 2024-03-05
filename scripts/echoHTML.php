<?php
    function echoHead($fileTitle, $jsTitle, $cssTitle) {
        echo '
            <!DOCTYPE html>
            <html>
                <head>
                    <title>'.$fileTitle.'</title>
                    <script src = "'.$jsTitle.'.js"></script>
                    <link rel = "stylesheet" type = "text/css" href = "'.$cssTitle.'.css">
                </head>';
    }//echoHead()

    function echoHeader($title) {
        require_once '../app_config.php';

        echo '
            <body>
                <main>
                    <header>
                        <h1>'.$title.'</h1>
                        
                        <ul class="menu">
                            <li>
                                <button>Home</button>
                            </li>

                            <li>
                                <button>Account</button>
                                
                                <ul class="submenu">
                                    <li>Login</li>
                                    <li><a href="landingPage.php">Register</a></li>
                                    <li>Manage</li>
                                </ul>
                            </li>
                            
                            <li>
                                <button>Email Us</button>
                            </li>

                            <li>
                                <button>Logout</button>
                            </li>
                        </ul>
                    </header>';
    }//echoHeader()

    function echoFooter() {
        date_default_timezone_set('America/Chicago');
        echo '
                    <footer>
                        <p>'.date("l jS \of F Y h:i:s A").' &copy; '.'Copyright by Josh Derr'.'</p>
                    </footer>
                </main>
            </body>
        <html>';
    }//echoFooter()
?>