<?php

namespace iutnc\sae\action;

use DateTime;
use iutnc\sae\action\Action;
use iutnc\sae\db\ConnectionFactory;

class ActivationAction extends Action {

    private $token;

    public function __construct($token) {
        $this->token = $token;
    }

    public function execute() : string {
        if ($this->verifyToken($this->token)) {
            if ($this->activateUser($this->token)) {
                $html = "<p>Votre compte a été activé</p>";
                $html .= "<br><a href='?action=signin'>Connection</a>";
            } else {
                $html = "<p>Erreur lors de l'activation du compte</p>";
            }
        } else {
            $html = "<p>Lien expiré</p>";
        }
        return $html;
    }

    /**
     * Vérifie si le token est valide et n'est pas expiré
     * @param $token
     * @throws \Exception
     */
    public static function verifyToken($token) : bool {
        $db = ConnectionFactory::makeConnection();
        $query = $db->prepare('SELECT * FROM User WHERE activation_token = ?');
        $query->execute([$token]);
        $result = $query->fetch();
        if ($result) {
            $date = new DateTime($result['activation_expires']);
            $now = new DateTime();
            if ($date > $now) {
                return true;
            }
        }
        return false;
    }

    public function activateUser($token) : bool {
        $db = ConnectionFactory::makeConnection();
        $query = $db->prepare('UPDATE User SET active = 1 WHERE activation_token = ?');
        $query->bindParam(1, $token);
        $query->execute();
        return $query->rowCount() == 1;
    }


}
