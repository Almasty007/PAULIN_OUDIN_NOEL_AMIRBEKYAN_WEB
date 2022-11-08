<?php

namespace iutnc\sae\dispatch;

use iutnc\sae\action\Action;
use iutnc\sae\action\AddUserAction;
use iutnc\sae\action\Catalogue;
use iutnc\sae\action\LogoutAction;
use iutnc\sae\action\SigninAction;
use iutnc\sae\exception\NotStrengthPassWord;
use iutnc\sae\media\Serie;

class Dispatcher {


    public function __construct() {
    }

    private function renderPage(string $html) : void {
        $res = <<<HTML
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>NetVOD</title>
                    <link rel="stylesheet" type="text/css" href="style.css">
                </head>
                <body>
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
                $action = new Catalogue();
                break;
            case "regarder":
                $this->lancerEpisode();
                return;
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

    public function lancerEpisode(){
        echo Serie::affichier($_GET['id']);
    }
}