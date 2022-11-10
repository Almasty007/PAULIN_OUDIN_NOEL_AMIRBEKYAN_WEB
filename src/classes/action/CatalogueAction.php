<?php

namespace iutnc\sae\action;

use iutnc\sae\db\ConnectionFactory;

class CatalogueAction extends Action {

    public function execute(): string{
        $res = "<HTML>";
        $bd = ConnectionFactory::makeConnection();
        $rep = $bd->query("select * from serie");
        $res.= '<form action="?action=catalogue" method="post" class="log-form">
                    <label>Rechercher </label><input name="chaine">
                    <button type="submit">Validate</button>
                </form>';
        $res.= "<div class=\"series\">";
        while ($row = $rep->fetch()){
             $res.="<div class='video-div'><a href=?action=serie&id=".$row[0]."><img class='img-video' src='image/$row[3]'></a><a class=\"serie\" href=?action=serie&id=".$row[0].">".$row[1]."</a></div>";
        }
        return $res."</div></HTML>";
    }


}
