<?php

namespace iutnc\sae\action;

use iutnc\sae\db\ConnectionFactory;

class Catalogue extends Action {

    public function execute(): string{
        $res = "<HTML> <body>";
        $bd = ConnectionFactory::makeConnection();
        $rep = $bd->query("select * from serie");
        while ($row = $rep->fetch()){
             $res.="<a href=?action=regarder&id=".$row[0].">".$row[1]."</a></br>";
        }
        return $res."</HTML>";
    }
}
