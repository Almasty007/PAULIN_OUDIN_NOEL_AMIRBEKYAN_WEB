<?php

namespace iutnc\sae\dispatch;

use iutnc\sae\action\Action;
use iutnc\sae\action\AddUserAction;
use iutnc\sae\action\CatalogueAction;
use iutnc\sae\action\LogoutAction;
use iutnc\sae\action\SelectionEpisodeAction;
use iutnc\sae\action\SelectionSerieAction;
use iutnc\sae\action\SigninAction;
use iutnc\sae\action\SupprimerPref;
use iutnc\sae\baseChange\AjouterPref;

class Dispatcher {

    public function __construct() {
    }

    private function renderPage(string $html) : void {
        $res = <<<HTML
            <!DOCTYPE html>
            <html lang="">
                <head>
                    <meta charset="utf-8">
                    <title>NetVOD</title>
                    <link rel="stylesheet" type="text/css" href="style.css">
                </head>
                <body>
                    <div class="header">
                        <a id="title" href="index.php">NetVOD</a>
                    </div>
                    $html
                </body>
            </html>
        HTML;
        echo $res;
    }

    public function run() : void {
        switch ($_GET['action']) {
            case "signin":
                $action = new SigninAction();
                break;
            case "add-user":
                $action = new AddUserAction();
                break;
            case "logout":
                $action = new LogoutAction();
                break;
            case "catalogue":
                $action = new CatalogueAction();
                break;
            case "serie":
                $action = new SelectionSerieAction($_GET['id']);
                break;
            case "ajouterpref":
                AjouterPref::execute();
                $action = new SelectionSerieAction($_GET['id_serie']);
                break;
            case "supprimerpref":
                SupprimerPref::execute();
                $action = new SelectionSerieAction($_GET['id_serie']);
                break;
            case "regarder":
                $action = new SelectionEpisodeAction($_GET['id'],$_GET['id_ep']);
                break;
            default:
                echo "mauvaise 'action'";
                break;
        }
        try {
                $this->renderPage($action->execute());
        }
        catch (\Error $e) {
            header("Location:index.php");
        }
    }
}