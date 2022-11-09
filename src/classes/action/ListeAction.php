<?php

namespace iutnc\sae\action;

use iutnc\sae\db\ConnectionFactory;

class ListeAction extends Action{

    public string $table;

    public function __construct($table){
        $this->table = $table;
    }

    public function execute(): string{
        $res = "";
        $bd = ConnectionFactory::makeConnection();
        $id = $_SESSION['id'];
        switch ($this->table){
            case "listPref":
                $res.= "Film prefere: </br>";
                break;
            case "EnCour":
                $res.= "En cour de visionnage: </br>";
                break;
            case "listSerieVisionner":
                $res.= "Deja visionner: </br>";
                break;
        }
        $rep0 = $bd->query("select count(*)from $this->table where iduser = $id");
        $r1 = $rep0->fetch();
        $nbrFilm = $r1[0];
        if($nbrFilm == 0){
            $res.= "<p>Pas de serie dans la liste";
        }
        else{
            $rep = $bd->query("select serie.id, titre from $this->table inner join serie on serie.id = $this->table.idserie where iduser = $id");
            while ($row = $rep->fetch()){
                $res.="<a href=?action=serie&id=".$row[0].">".$row[1]."</a></br>";
            }
        }
        return $res;
    }
}