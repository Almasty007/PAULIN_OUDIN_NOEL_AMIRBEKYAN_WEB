<?php

namespace iutnc\sae\media;

use iutnc\sae\baseChange\AjouterEnCour;
use iutnc\sae\db\ConnectionFactory;

class Episode
{

    public static function afficher(string $id_serie, string $id_episode): string
    {
        $res = "";
        $bd = ConnectionFactory::makeConnection();
        $query = $bd->prepare("select * from episode where id = ?");
        $query->bindParam(1, $id_episode);
        $query->execute();
        $row = $query->fetch();
        $res .= "<div class=\"description\"><p>Epidode numero : ".$row[1]."Titre : ".$row[2]."</p><p>Resume : ".$row[3]."</p><p>Duree : ".$row[4]."</div>";

        $res.='<div class="video"><video controls width="1000"><source src="video/'.$row[5].'"> type="video/webm"</video></div>';
        $res.="
        <form method='post' action='?action=ajout-comm&id=".$id_serie."&id_ep=".$id_episode."' class='comment-form'>
        <h2>Note</h2>
        <select name='note'>
        <option value='1'>1</option>
        <option value='2'>2</option>
        <option value='3'>3</option>
        <option value='4'>4</option>
        <option value='5'>5</option></select>
        <h2>Commentaire</h2>
        <textarea maxlength='520' name='commentaire' placeholder='Commentaire' required></textarea><br>
        <button type='submit'>Envoyer</button></form><a href=?action=serie&id=".$id_serie.">Retour</a>";
        AjouterEnCour::execute();
        return $res;
    }
}