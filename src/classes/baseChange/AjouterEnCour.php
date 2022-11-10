<?php

namespace iutnc\sae\baseChange;

use iutnc\sae\db\ConnectionFactory;
use PDOException;

class AjouterEnCour
{

    public static function execute()
    {
        $bd = ConnectionFactory::makeConnection();
        $idUser = $_SESSION['id'];
        $id_serie = $_GET["id"];
        $req01 = $bd->query("select count(*) from EnCour where idserie = $id_serie and iduser = $idUser");
        $r01 = $req01->fetch();
        $req02 = $bd->query("select count(*) from listSerieVisionner where idserie = $id_serie and iduser = $idUser");
        $r02 = $req02->fetch();
        if ($r01[0] == 0 and $r02[0] == 0) {
            $req = $bd->prepare("insert into EnCour values(?,?)");
            $req->bindParam(1, $id_serie);
            $req->bindParam(2, $idUser);
            $req->execute();
        }
        $id_ep = $_GET["id_ep"];
        $id_first_ep = $bd->query("select min(id) from episode where serie_id = $id_serie")->fetch()[0];
        for ($i = $id_first_ep; $i <=$id_ep; $i++){
            try {
                $bd->query("insert into listEpisodeVisionner values($idUser,$i,$id_serie)");
            }catch(PDOException){

            }
        }
        $req = $bd->query("select count(*) from listSerieVisionner where idserie = $id_serie");
        $res = $req->fetch();
        if ($res[0] == 0) {
            $nombreEpVisioner = $bd->query("select count(*) from listEpisodeVisionner where idserie = $id_serie and iduser = $idUser");
            $rnbEpVisionner = $nombreEpVisioner->fetch();
            $nbEp = $bd->query("select count(*) from episode where serie_id = $id_serie");
            $rnbEp = $nbEp->fetch();
            if ($rnbEp[0] == $rnbEpVisionner[0]) {
                $req = $bd->prepare("insert into listSerieVisionner values(?,?)");
                $req->bindParam(1, $id_serie);
                $req->bindParam(2, $idUser);
                $req->execute();
                $bd->query("delete from EnCour where idserie = $id_serie and iduser = $idUser");
            }
        }
    }
}