<?php

namespace iutnc\sae\db;

class ProfilUpdate
{

 static function update(string $iduser):void{
    $bd = ConnectionFactory::makeConnection();
    $query = $bd->query('Update profil set nom = "'.$_POST['nom'].'" where user_id = "'.$iduser.'"');
    $query = $bd->query('Update profil set prenom = "'.$_POST['prenom'].'" where user_id = "'.$iduser.'"');
    $query = $bd->query('Update profil set pseudo = "'.$_POST['pseudo'].'" where user_id = "'.$iduser.'"');
    $query = $bd->query('Update profil set date_naissance = "'.$_POST['date'].'" where user_id = "'.$iduser.'"');
}

}