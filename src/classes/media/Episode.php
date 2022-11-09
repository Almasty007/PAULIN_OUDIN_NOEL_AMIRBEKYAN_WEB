<?php

namespace iutnc\sae\media;

use iutnc\sae\baseChange\AjouterEnCour;
use iutnc\sae\db\ConnectionFactory;

class Episode
{

    public static function afficher(string $id_serie, string $id_episode): string
    {
        $res = "";
        $bd = ConnectionFactory::makeConnection();
        $query = $bd->prepare("select * from episode where id = ?");
        $query->bindParam(1, $id_episode);
        $query->execute();
        $row = $query->fetch();
        $res .= "<div class=\"description\"><p>Epidode numero : ".$row[1]."Titre : ".$row[2]."</p><p>Resume : ".$row[3]."</p><p>Duree : ".$row[4]."</div>";

        $res.='<div class="video"><video controls width="1000"><source src="video/'.$row[5].'"> type="video/webm"</video></div>';
        $res.="<a href=?action=serie&id=".$id_serie.">Retour</a>";
        AjouterEnCour::execute();
        return $res;
    }
}