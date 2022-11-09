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
        $rep0 = $bd->query("select count(*)from $this->table where iduser = $id");
        $r1 = $rep0->fetch();
        $nbrFilm = $r1[0];
        if($nbrFilm == 0){
            $res.= "<p>Pas de film dans la liste $this->table</p>";
        }
        else{
            $rep = $bd->query("select serie.id, titre from $this->table inner join serie on serie.id = $this->table.idserie where iduser = $id");
            while ($row = $rep->fetch()){
                echo 'ici';
                $res.="<a href=?action=serie&id=".$row[0].">".$row[1]."</a></br>";
            }
        }
        return $res;
    }
}