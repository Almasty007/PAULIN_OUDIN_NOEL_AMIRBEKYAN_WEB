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

        try{
            $req01 = $bd->query("select count(*) from serie where id = $id");
            $r01 = $req01->fetch();
            $bool0 = $r01[0];
            if ($bool0 == 0) {
                throw new PDOException;
            }
            $id_util = $_SESSION['id'];
            $req0 = $bd->query("select count(*) from listPref where idserie = $id and iduser = $id_util");
            $r1 = $req0->fetch();
            $bool = $r1[0];
            if($bool == 1){
                $res.= '<a href=?action=supprimerpref&id_serie='.$id.'> Supprimer de mes préférences</a><br>';
            } else {
                $res.= '<a href=?action=ajouterpref&id_serie='.$id.'> Ajouter à mes préférences</a><br>';
            }

        } catch (\PDOException $e){
            //exception : si on interagie avec une serie non conforme attrape
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
        $res.="</tbody></table></div>
        <a href='?action=catalogue'>Retour</a><br><br><br><br>";
        $res.="<div class = 'note'><p>Note moyenne :</p>";
        $res.=self::calculerNote($id);
        $res.='</div>';
        $res.="<div class = 'commentaire'><p>Commentaires : </p>";
        $res.=self::getCommentaires($id);
        $res.='</div>';
        return $res;
    }
    
    public static function calculerNote(string $id):string {
        $bd = ConnectionFactory::makeConnection();
        $res="<p>Pas de note</p>";
        $compteur = 0;
        $tot = 0;
        $query = $bd->query("select note from avis where serie_id = '$id'");
        while ($row = $query->fetch()){
            $tot += $row[0];
            $compteur++;
        }
        if($compteur != 0){
            $res = '<p>'.round($tot / $compteur, 2).'</p><br>';
        }
        return $res;
    }

    public static function getCommentaires(string $id):string {
        $bd = ConnectionFactory::makeConnection();
        $res="";
        $query = $bd->query("select commentaire from avis where serie_id = '$id'");
        while ($row = $query->fetch()){
            $res.="<p>".$row[0]."</p><br>";
        }
        if($res == ""){
            $res = "<p>Aucun commentaire pour le moment</p> <br>";
        }
        return $res;

    }
}
