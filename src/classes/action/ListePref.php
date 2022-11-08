<?php

namespace iutnc\sae\action;

use iutnc\sae\db\ConnectionFactory;

class ListePref extends Action
{
    public function execute(): string{
        $res = "<HTML> <body>";
        $bd = ConnectionFactory::makeConnection();
        $id = $_SESSION['id'];
        $rep0 = $bd->query("select count(*)from listPref where idUtilisateur = '$id'");
        $r1 = $rep0->fetch();
        $nbrFilmPref = $r1[0];
        if($nbrFilmPref == 0){
            $res.= "pas de film preferes";
        }
        else{
            $rep = $bd->query("select serie.id, titre from listPref inner join serie on serie.id = listPref.idSerie where idUtilisateur = '$id'");
            while ($row = $rep->fetch()){
                $res.="<a href=?action=serie&id=".$row[0].">".$row[1]."</a></br>";
            }
        }
        return $res."</HTML>";
    }
}