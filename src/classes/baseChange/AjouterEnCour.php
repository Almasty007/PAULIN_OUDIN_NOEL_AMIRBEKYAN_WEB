<?php

namespace iutnc\sae\baseChange;

use iutnc\sae\db\ConnectionFactory;

class AjouterEnCour
{

    public static function execute()
    {
        $bd = ConnectionFactory::makeConnection();
        $idUser = $_SESSION['id'];
        $id_serie = $_GET["id"];
        $req01 = $bd->query("select count(*) from EnCour where idserie = $id_serie and iduser = $idUser");
        $r01 = $req01->fetch();
        if ($r01[0] == 0) {
            $req = $bd->prepare("insert into EnCour values(?,?)");
            $req->bindParam(1, $id_serie);
            $req->bindParam(2, $idUser);
            $req->execute();
        }
    }
}