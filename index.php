<?php

require_once "vendor/autoload.php";

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\dispatch\Dispatcher;
use iutnc\sae\action\SigninAction;
use iutnc\sae\action\AddUserAction;

session_start();
ConnectionFactory::setConfig("DBConfig.ini");
if (isset($_SESSION['user'])) {
    if (isset($_GET['action'])) {
        $dispatcher = new Dispatcher();
        $dispatcher->run();
    } else {
        $action = <<<HTML
            <p>HTML</p>
            <a href="?action=logout">Logout</a>
HTML;
        echo $action;
    }

} else {
    if (isset($_GET['action'])) {
        $dispatcher = new Dispatcher();
        $dispatcher->run();
    } else {
        $action = <<<HTML
    <html>
        <head>
            <meta charset="utf-8">
            <title>NetVOD</title>
            <link rel="stylesheet" type="text/css" href="style.css">
        </head>
        <body>
            <div class="header">
                <a id="title" href="">NetVOD</a>
                <div class="header-bottom">
                    <a id="signin" href="?action=signin">Sign in</a>
                    <a id="signup" href="?action=add-user">Sign up</a>
                </div>
            </div>
        </body>
    </html>
HTML;
        echo $action;
    }
}