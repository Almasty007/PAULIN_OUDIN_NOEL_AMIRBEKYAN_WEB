<?php

namespace iutnc\sae\media;

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\media\Image;

class Episode
{

    public static function affichier(string $id_serie,string $id_episode): string
    {
        $res = "";
        $bd = ConnectionFactory::makeConnection();
        $query = $bd->prepare("select * from episode where id = ?");
        $query->bindParam(1, $id_episode);
        $query->execute();
        $row = $query->fetch();
        $res .= "<div class=\"description\"><p>Epidode numero : ".$row[1]."Titre : ".$row[2]."</p><p>Resume : ".$row[3]."</p><p>Duree : ".$row[4]."</div>";

        $res.='<video controls width="1000"><source src="/sae/video/'.$row[5].'"> type="video/webm"</video>';
        $res.="<a href=?action=serie&id=".$id_serie.">Retour</a>";
        return $res;
    }
}