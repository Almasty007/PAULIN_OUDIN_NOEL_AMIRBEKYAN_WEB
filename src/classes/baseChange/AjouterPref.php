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
        $req0 = $bd->query("select count(*) from listPref where idSerie = $id_serie and idUtilisateur = $id");
        $r1 = $req0->fetch();
        $bool = $r1[0];
        if ($bool == 0) {
            $req = $bd->prepare("insert into listPref values(?,?)");
            $req->bindParam(1, $id_serie);
            $req->bindParam(2, $id);
            $req->execute();
            echo "<script type='text/javascript'>alert('la serie a ete ajouter a votre liste de preferance');</script>";
        }
    }
}