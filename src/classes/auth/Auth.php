<?php

namespace iutnc\sae\auth;

use iutnc\sae\db\ConnectionFactory;
use iutnc\sae\db\User;
use iutnc\sae\exception\EmailAlreadyRegistedException;
use iutnc\sae\exception\NotStrengthPassWord;
use iutnc\sae\exception\TooShortPasswordException;
use PDO;

class Auth {
    /**
     * @throws EmailAlreadyRegistedException
     * @throws TooShortPasswordException
     * @throws NotStrengthPassWord
     */
    public static function register(string $email, string $password) : bool {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
        $hash = password_hash($password, PASSWORD_DEFAULT, ['cost'=>12]);
        $bd = ConnectionFactory::makeConnection();
        $query = $bd->prepare("select * from User where login = ?"); $query->bindParam(1, $email); $query->execute();
        if($query->rowCount() > 0) throw new EmailAlreadyRegistedException("Email has already registed");
        if (self::checkPassStrength($password, 10)) {
            $query = $bd->prepare("insert into User (login, mdp) values(?, ?)");
            $query->bindParam(1, $email);
            $query->bindParam(2, $hash);
            $query->execute();
            $query = $bd->prepare("insert into Compte (nomCompte) values(?)");
            $nomCompte = explode('@', $email)[0];
            $query->bindParam(1, $nomCompte);
            $query->execute();
            $nomCompte = explode('@', $email)[0];

            $idCompte = $bd->prepare("select idCompte from Compte where nomCompte = ?");
            $idCompte->bindParam(1, $nomCompte);
            $idCompte ->execute();
            $idCompteVal = $idCompte->fetch()[0];

            $idUser = $bd->prepare("select idUser from User where login = ?");
            $idUser->bindParam(1, $email);
            $idUser ->execute();
            $idUserVal = $idUser->fetch()[0];

            $query = $bd->prepare("insert into account (idCompte, idUser) values(?, ?)");

            $query->bindParam(1, $idCompteVal);
            $query->bindParam(2, $idUserVal);
            $query->execute();
            return true;
        }else{
            return false;
        }
    }

    public static function checkPassStrength(string $passwd, int $minLength):bool {
        $lenght = strlen($passwd) >= $minLength;
        if (!$lenght) throw new TooShortPasswordException("le mot de passe est trop court");
        $digit = preg_match("#\d#", $passwd);
        $special = preg_match("#\W#", $passwd);
        $lower = preg_match("#[a-z]#", $passwd);
        $upper = preg_match("#[A-Z]#", $passwd);
        if (! ($digit && $special && $lower && $upper)) throw new NotStrengthPassWord("le mot de passe n'est pas asses protoge");
        return true;
    }

    public static function loadProfile(string $email): void {

    }

    public static function checkAccesLevel(int $required):void {}


    public static function checkOwner(int $oId, int $plId):bool {
        $base = ConnectionFactory::makeConnection();
        $result = $base->prepare("SELECT id_pl FROM user2playlist WHERE id_user = ?");
        $result->bindParam(1, $oId);
        $result->execute();
        $auth = false;
        while($data = $result->fetch()) {
            if($plId == $data['id_pl']) {
               $auth = true;
               break;
            }
        }
        $result->closeCursor();
        return $auth;
    }
    public static function generateActivationToken(string $email) : string {return "";}
    public static function activate(string $token) : bool {return false;}

    public static function authenticate(string $email, string $passwd2check): bool {
        $bd = ConnectionFactory::makeConnection();
        $query = $bd->prepare("select * from User where login = ? ");
        $query->bindParam(1, $email);
        $query->execute();
        $data = $query->fetch(PDO::FETCH_ASSOC);
        $hash = $data['mdp'];
        if (!password_verify($passwd2check, $hash)) {echo "mdp faux"; return false;}
        $_SESSION['user'] = serialize(new User($email, $passwd2check));
        return true;
    }
}