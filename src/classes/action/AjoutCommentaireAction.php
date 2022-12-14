<?php

namespace iutnc\sae\action;

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\db\User;
use iutnc\sae\media\Episode;

class AjoutCommentaireAction extends Action
{
    private string $ids;
    private string $ide;

    public function __construct(string $idserie, string $idepisode)
    {
        $this->ids = $idserie;
        $this->ide = $idepisode;
    }

    public function execute(): string
    {
        $commentaire = true;
        $bd = ConnectionFactory::makeConnection();
        $res = $bd->query("select count(note) from avis where serie_id ='" . $this->ids . "' and user_id = '" . $_SESSION['id'] . "';");
        $result = $res->fetch();
        $note = $result[0];
        if ($note == 0) {
            $commentaire = false;
            $res = $bd->prepare("insert into avis(user_id,serie_id,note,commentaire) values (?,?,?,?);");
            $res->bindParam(1, $_SESSION['id']);
            $res->bindParam(2, $this->ids);
            $res->bindParam(3, $_POST['note']);
            $commentaire_filtre = filter_var($_POST['commentaire'], FILTER_SANITIZE_STRING);
            $res->bindParam(4, $commentaire_filtre);
            $res->execute();
        }
        $ch = Episode::afficher($this->ids,$this->ide);
        if ($commentaire) {
            $ch = "<p>Vous avez déjà noté et commenté cette serie</p>
                    <a href=?action=regarder&id=" . $this->ids . "&id_ep=".$this->ide.">Retour</a>";
        }
        return $ch;
    }
}