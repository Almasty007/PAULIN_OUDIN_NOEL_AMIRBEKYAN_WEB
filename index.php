<?php

require_once "vendor/autoload.php";

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\dispatch\Dispatcher;
use iutnc\sae\action\SigninAction;
use iutnc\sae\action\AddUserAction;

session_start();
ConnectionFactory::setConfig("DBConfig.ini");
//Si l'utilisateur est connecté, on affiche la page qui propose d'afficher le catalogue
if (isset($_SESSION['user'])) {
    if (isset($_GET['action'])) {
        $dispatcher = new Dispatcher();
        $dispatcher->run();
    } else {
        $listPref = new \iutnc\sae\action\ListePrefAction();
        $action = <<<HTML
                    <a href="?action=logout">Logout</a>
                    <a href="?action=catalogue">Catalogue</a>
HTML;
        $action.= $listPref->execute();
        echo ajouterIndex($action);
    }
}
//Sinon (s'il n'est pas connecté), on affiche la page qui propose de se connecter ou de créer un compte
else {
    if (isset($_GET['action'])) {
        if ($_GET['action'] === "signin" or $_GET['action'] === "add-user") {
            $dispatcher = new Dispatcher();
            $dispatcher->run();
        }
    } else {
        $action = <<<HTML
                    <a id="signin" href="?action=signin">Se connecter</a>
                    <a id="signup" href="?action=add-user">S'inscrire</a>
HTML;
        echo ajouterIndex($action);
    }
}

//L'affichage principale de l'index
function ajouterIndex(string $html) : string {
    $code = <<<HTML
    <html>
        <head>
            <meta charset="utf-8">
            <title>NetVOD</title>
            <link rel="stylesheet" type="text/css" href="style.css">
        </head>
        <body>
            <div class="header">
                <a id="title" href="">NetVOD</a>
                <div class="main">
                    $html
                </div>
            </div>
        </body>
    </html>
    HTML;
    return $code;
}