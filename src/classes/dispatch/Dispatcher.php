<?php

namespace iutnc\sae\dispatch;

use iutnc\sae\action\ActivationAction;
use iutnc\sae\action\AddUserAction;
use iutnc\sae\action\AjoutCommentaireAction;
use iutnc\sae\action\CatalogueExecuteSearch;
use iutnc\sae\action\CatalogueSearchAction;
use iutnc\sae\action\LogoutAction;
use iutnc\sae\action\ModifProfilAction;
use iutnc\sae\action\SelectionEpisodeAction;
use iutnc\sae\action\SelectionSerieAction;
use iutnc\sae\action\SigninAction;
use iutnc\sae\baseChange\AjouterPref;
use iutnc\sae\baseChange\ProfilUpdate;
use iutnc\sae\baseChange\SupprimerPref;

class Dispatcher {

    public function __construct() {
    }

    private function renderPage(string $html) : void {
        $res = <<<HTML
            <!DOCTYPE html>
            <html lang="fr">
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
                $classeTemp = new CatalogueSearchAction();
                if(!isset($_POST['chaine'])){
                    $_POST['chaine'] =  "";
                }
                $action = new CatalogueExecuteSearch($classeTemp, filter_var($_POST['chaine'], FILTER_SANITIZE_STRING));
                $_POST['chaine'] =  "";
                //$action = new CatalogueAction();
                break;
            case "serie":
                $action = new SelectionSerieAction($_GET['id'], true);
                break;
            case "continuerSerie":
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
            case "ajout-comm":
                $action = new AjoutCommentaireAction($_GET['id'],$_GET['id_ep']);
                break;
            case "activation":
                $action = new ActivationAction($_GET['token']);
                break;
            case "profilmodif":
                ProfilUpdate::update();
            case "profil":
                $action = new ModifProfilAction();
                break;
            default:
                echo "mauvaise 'action'";
                break;
        }
        try {
                $this->renderPage($action->execute());
        }
        catch (\Erro $e) {
            header("Location:index.php");
        }
    }
}