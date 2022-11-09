<?php

namespace iutnc\sae\action;

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\db\User;

class AjoutCommentaireAction
{

    static function execute(string $idserie):void
    {
        $bd = ConnectionFactory::makeConnection();
        $res = $bd->query("select count(note) from avis where serie_id ='".$idserie."' and user_id = '".$_SESSION['id']."';");
        $result = $res->fetch();
        $note = $result[0];
        if($note == 0){
            $res = $bd->prepare("insert into avis(user_id,serie_id,note) values (?,?,?);");
            $res->bindParam(1,$_SESSION['id']);
            $res->bindParam(2,$idserie);
            $res->bindParam(3,$_POST['note']);
            $res->execute();
        }
        header('');
    }
}