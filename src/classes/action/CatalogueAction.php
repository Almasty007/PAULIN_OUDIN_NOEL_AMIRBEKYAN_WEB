<?php

namespace iutnc\sae\action;

use iutnc\sae\db\ConnectionFactory;

class CatalogueAction extends Action {

    public function execute(): string{
        $res = "<HTML> <body>";
        $bd = ConnectionFactory::makeConnection();
        $rep = $bd->query("select * from serie");
        $res.= "<div class=\"series\">";
        while ($row = $rep->fetch()){
             $res.="<a class=\"serie\" href=?action=regarder&id=".$row[0].">".$row[1]."</a></br>";
        }
        return $res."</div></body></HTML>";
    }
}
