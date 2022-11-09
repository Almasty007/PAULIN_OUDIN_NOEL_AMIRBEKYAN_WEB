<?php

namespace iutnc\sae\baseChange;

use iutnc\sae\action\PDOException;
use iutnc\sae\db\ConnectionFactory;

class AjouterPref
{
    public static function execute()
    {
        $bd = ConnectionFactory::makeConnection();
        $id = $_SESSION['id'];
        $id_serie = $_GET["id_serie"];
        $req0 = $bd->query("select count(*) from listPref where idserie = $id_serie and iduser = $id");
        $r1 = $req0->fetch();
        $bool = $r1[0];
        if ($bool == 0) {
            $req = $bd->prepare("insert into listPref values(?,?)");
            $req->bindParam(1, $id);
            $req->bindParam(2, $id_serie);
            $req->execute();
            //echo "<script type='text/javascript'>alert('la serie a ete ajouter a votre liste de preferance');</script>";
        }
    }
}