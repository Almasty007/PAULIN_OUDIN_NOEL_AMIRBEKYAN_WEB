<?php

namespace iutnc\sae\action;
use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\action\CatalogueAction;

class CatalogueSearchAction extends CatalogueAction
{
    public function executeWithArg(string $ch): string
    {
        if($ch == ""){
             return self::execute();
        }else {
            $res = "<HTML>";
            $bd = ConnectionFactory::makeConnection();
            $rep = $bd->query("select * from serie where lower(descriptif) like lower('%$ch%') or lower(titre) like lower('%$ch%')");
            $res.= '<form action="?" method="get" class="log-form">
                    <button type="submit" >Retour</button>
                    <input type="hidden" name="action" value="catalogue">
                    </form>';
            $res.= "<div class=\"series\">";
            while ($row = $rep->fetch()){
                $res.="<div class='video-div'><a href=?action=serie&id=".$row[0]."><img class='img-video' src='image/$row[3]'></a><a class=\"serie\" href=?action=serie&id=".$row[0].">".$row[1]."</a></div>";
            }

            return $res."</div></HTML>";
        }

    }
}