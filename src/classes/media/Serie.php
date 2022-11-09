<?php

namespace iutnc\sae\media;
use iutnc\sae\action\Action;
use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\media\Episode;

class Serie
{

    public static function afficher(string $id): string
    {
        $res = "";
        $bd = ConnectionFactory::makeConnection();


        $req01 = $bd->query("select count(*) from serie where id = $id");
        $r01 = $req01->fetch();
        $bool0 = $r01[0];
        if ($bool0 == 0) {
            throw new PDOException;
        }
        $id_util = $_SESSION['id'];
        $req0 = $bd->query("select count(*) from listPref where idSerie = $id and idUtilisateur = $id_util");
        $r1 = $req0->fetch();
        $bool = $r1[0];
        if($bool == 1){
            $res.= '<a href=?action=supprimerpref&id_serie='.$id.'> Supprimer de mes préférences</a><br>';
        } else {
            $res.= '<a href=?action=ajouterpref&id_serie='.$id.'> Ajouter à mes préférences</a><br>';
        }


        $query = $bd->prepare("select * from serie where id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        while ($row = $query->fetch()){
            $res .= "<div class=\"description\"><p>Titre : ".$row[1]."</p><p>Description : ".$row[2]."</p><p>Annee : ".$row[4]." </p><p>Date d'ajout : ".$row[5]."</p></div>";
        }
        $query = $bd->prepare("select count(*) from episode where serie_id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        $row = $query->fetch();
        $res.= "<p>Nombre d'episode : ".$row[0]."</p>";
        $query = $bd->prepare("select * from episode where serie_id = ?");
        $query->bindParam(1, $id);
        $query->execute();
        $res.="<br>";
        $res.="<div class=\"episodes\">";
        $res.="<table><tbody>";
        while ($row = $query->fetch()){
            $res .= "<tr><td class=\"td-lien\"><a href=?action=regarder&id_ep=".$row[0]."&id=".$id.">".$row[2]."</a></td><td><p>Episode ".$row[1]."</p></td></tr>";
        }
        $res.="</tbody></table></div><a href='?action=catalogue'>Retour</a>";
        return $res;
    }
}