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
            $res .= "titre : ".$row[1]." description : ".$row[2]."</br> annee : ".$row[4]." date d'ajout : ".$row[5];
        }
        return $res."</body></HTML>";
    }
}