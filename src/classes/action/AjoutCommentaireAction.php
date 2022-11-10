<?php

namespace iutnc\sae\action;

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\db\User;

class AjoutCommentaireAction extends Action
{
    private bool $commentaire;
    private string $id;

    public function __construct(string $idserie)
    {
        $this->id = $idserie;
        $bd = ConnectionFactory::makeConnection();
        $res = $bd->query("select count(note) from avis where serie_id ='" . $idserie . "' and user_id = '" . $_SESSION['id'] . "';");
        $result = $res->fetch();
        $note = $result[0];
        if ($note == 0) {
            $this->commentaire = false;
            $res = $bd->prepare("insert into avis(user_id,serie_id,note,commentaire) values (?,?,?,?);");
            $res->bindParam(1, $_SESSION['id']);
            $res->bindParam(2, $idserie);
            $res->bindParam(3, $_POST['note']);
            $res->bindParam(4, $_POST['commentaire']);
            $res->execute();
        } else {
            $this->commentaire = true;
        }
    }

    public function execute(): string
    {
        $ch = " ";
        if ($this->commentaire) {
            $ch = "<p>Vous avez deja note et commente cette serie</p>
                    <a href='?action=serie&id='" . $this->id . "></a>";
        }
        return $ch;
    }
}