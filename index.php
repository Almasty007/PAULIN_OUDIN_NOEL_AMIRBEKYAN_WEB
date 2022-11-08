<?php

require_once "vendor/autoload.php";

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\dispatch\Dispatcher;
use iutnc\sae\action\SigninAction;
use iutnc\sae\action\AddUserAction;

session_start();
ConnectionFactory::setConfig("DBConfig.ini");
if (isset($_SESSION['user'])){
    if (isset($_GET['action'])){
        $dispatcher = new Dispatcher();
        $dispatcher->run();
    }
    else {
        $action = <<<HTML
            <p>HTML</p>
            <a href="?action=logout">Logout</a>
HTML;
        echo $action;
    }

}
else {
    if (isset($_GET['action'])){
        $dispatcher = new Dispatcher();
        $dispatcher->run();
    }
    else {
        $action = <<<HTML
            <a href="?action=add-user">inscription</a><br>
            <a href="?action=signin">connection</a><br>
        HTML;
        echo $action;
    }
}