<?php

namespace iutnc\sae\action;

use iutnc\sae\db\ConnectionFactory;

class ListePrefAction extends Action
{
    public function execute(): string{
        $res = "";
        $bd = ConnectionFactory::makeConnection();
        $id = $_SESSION['id'];
        $rep0 = $bd->query("select count(*)from listPref where idUser = '$id'");
        $r1 = $rep0->fetch();
        $nbrFilmPref = $r1[0];
        if($nbrFilmPref == 0){
            $res.= "<p>Pas de film préféré</p>";
        }
        else{
            $rep = $bd->query("select serie.id, titre from listPref inner join serie on serie.id = listPref.idSerie where idUser = '$id'");
            while ($row = $rep->fetch()){
                $res.="<a href=?action=serie&id=".$row[0].">".$row[1]."</a></br>";
            }
        }
        return $res;
    }
}