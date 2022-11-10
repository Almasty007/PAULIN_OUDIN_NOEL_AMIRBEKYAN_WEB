<?php

namespace iutnc\sae\action;

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\db\User;

class AjoutCommentaireAction extends Action
{
    private string $id;

    public function __construct(string $idserie)
    {
        $this->id = $idserie;
    }

    public function execute(): string
    {
        $commentaire = true;
        $bd = ConnectionFactory::makeConnection();
        $res = $bd->query("select count(note) from avis where serie_id ='" . $this->id . "' and user_id = '" . $_SESSION['id'] . "';");
        $result = $res->fetch();
        $note = $result[0];
        if ($note == 0) {
            $commentaire = false;
            $res = $bd->prepare("insert into avis(user_id,serie_id,note,commentaire) values (?,?,?,?);");
            $res->bindParam(1, $_SESSION['id']);
            $res->bindParam(2, $this->id);
            $res->bindParam(3, $_POST['note']);
            $res->bindParam(4, $_POST['commentaire']);
            $res->execute();
        }
        $ch = " ";
        if ($commentaire) {
            $ch = "<p>Vous avez deja note et commente cette serie</p>
                    <a href=?action=serie&id=" . $this->id . ">Retour</a>";
        }
        return $ch;
    }
}