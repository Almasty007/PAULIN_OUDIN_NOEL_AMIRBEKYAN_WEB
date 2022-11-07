<?php

require_once "vendor/autoload.php";

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\dispatch\Dispatcher;

ConnectionFactory::setConfig("DBConfig.ini");
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