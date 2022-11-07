<?php

namespace iutnc\sae\dispatch;

use iutnc\sae\action\Action;
use iutnc\sae\action\AddUserAction;
use iutnc\sae\action\SigninAction;

class Dispatcher {


    public function __construct() {
    }

    private function renderPage(string $html) : void {
        $res = <<<HTML
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="utf-8">
                    <title>Deefy</title>
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
            default:
                echo "mauvaise 'action'";
                break;
        }
        $this->renderPage($action->execute());
    }

}