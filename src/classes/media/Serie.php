<?php

namespace iutnc\sae\media;
use iutnc\sae\action\Action;
use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\media\Episode;

class Serie
{

    public static function affichier(string $id): string
    {
        $res = "<HTML> <body>";
        $bd = ConnectionFactory::makeConnection();
        $query = $bd->prepare("select * from serie where id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        while ($row = $query->fetch()){
            $res .= "titre : ".$row[1]." description : ".$row[2]." annee : ".$row[4]." date d'ajout : ".$row[5];
        }
        $query = $bd->prepare("select count(*) from episode where serie_id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        $row = $query->fetch();
        $res.= " nombre d'episode : ".$row[0];
        $query = $bd->prepare("select * from episode where serie_id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        $res.="</br>";
        while ($row = $query->fetch()){
            $res .= "<a href=?action=regarder&id_ep=".$row[0].">".$row[2]."</a> numero d'episode".$row[1]."</br>";
        }
        return $res."</body></HTML>";
    }
}