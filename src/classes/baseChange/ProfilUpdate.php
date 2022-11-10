<?php

namespace iutnc\sae\baseChange;

use iutnc\sae\db\ConnectionFactory;

class ProfilUpdate
{

 static function update():void{
     $iduser = $_SESSION['id'];
    $bd = ConnectionFactory::makeConnection();
    $nomfiltre = filter_var($_POST['nom'],FILTER_SANITIZE_STRING);
    $prenomfiltre = filter_var($_POST['prenom'],FILTER_SANITIZE_STRING);
    $pseudofiltre = filter_var($_POST['pseudo'],FILTER_SANITIZE_STRING);
    $query = $bd->query('Update profil set nom = "'.$nomfiltre.'" where user_id = "'.$iduser.'"');
    $query = $bd->query('Update profil set prenom = "'.$prenomfiltre.'" where user_id = "'.$iduser.'"');
    $query = $bd->query('Update profil set pseudo = "'.$pseudofiltre.'" where user_id = "'.$iduser.'"');
    $query = $bd->query('Update profil set date_naissance = "'.$_POST['date'].'" where user_id = "'.$iduser.'"');
}

}