<?php

namespace iutnc\sae\addUrl;

use iutnc\sae\db\ConnectionFactory;

class AjouterPref
{
    public function execute(): string
    {
        $res = "";
        $bd = ConnectionFactory::makeConnection();
        $id = $_SESSION['id'];
        $id_serie = $_GET["id_serie"];
        //$res .= "ajout a la listPref $id_serie:$id";
        try {
            /*
             * verifie que la serie existe sinon il lance une erreur
             * utile si l'utilisateur modifie le lien a sa guise
             */
            $req01 = $bd->query("select count(*) from serie where id = $id_serie");
            $r01 = $req01->fetch();
            $bool0 = $r01[0];
            if ($bool0 == 0) {
                throw new PDOException;
            }
            /*
             * regarde si l'utilisateur a deja ajoute la serie dans ses preferences,
             * si c'est le cas une notif nous l'averti
             */
            $req0 = $bd->query("select count(*) from listPref where idSerie = $id_serie and idUtilisateur = $id");
            $r1 = $req0->fetch();
            $bool = $r1[0];
            if ($bool == 0) {
                $req = $bd->prepare("insert into listPref values(?,?)");
                $req->bindParam(1, $id_serie);
                $req->bindParam(2, $id);
                $req->execute();
                $res .= '<script> alert("Vous avez ajouté cette série dans vos préférences");</script>';
            } else {
                $res .= '<script> alert("Vous aviez déjà cette série dans vos préférences");</script>';
            }
        } catch (PDOException $e) {
            $res .= '<script> alert("Utilisez une série qui existe");</script>';
        }
        header("Location:index.php");
        return $res;
    }
}