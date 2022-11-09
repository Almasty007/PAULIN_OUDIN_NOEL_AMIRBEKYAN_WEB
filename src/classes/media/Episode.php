<?php

namespace iutnc\sae\media;

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\media\Image;

class Episode
{

    public static function affichier(string $id): string
    {
        $res = "";
        $bd = ConnectionFactory::makeConnection();
        $query = $bd->prepare("select * from episode where id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        $row = $query->fetch();
        $res .= "<div class=\"description\"><p>Epidode numero : ".$row[1]."Titre : ".$row[2]."</p><p>Resume : ".$row[3]."</p><p>Duree : ".$row[4]."</div>";

        $res.='<video controls width="400"><src="/video/'.$row[6];
        $res.="<a href='?action=catalogue'>Retour</a>";
        return $res;
    }
}