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
            $res .= $row[1].$row[2].$row[4].$row[5];
        }
        return $res."</body></HTML>";
    }
}