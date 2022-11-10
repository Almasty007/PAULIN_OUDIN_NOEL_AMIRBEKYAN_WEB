<?php

namespace iutnc\sae\action;

use iutnc\sae\auth\Auth;
use iutnc\sae\exception\EmailAlreadyRegistedException;
use iutnc\sae\exception\NotStrengthPassWord;
use iutnc\sae\exception\TooShortPasswordException;
use iutnc\sae\db\ConnectionFactory;

class AddUserAction extends Action {

    public function execute() : string {
        $html = "";
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $html = <<<HTML
            <form action="?action=${_GET['action']}" method="post" class="log-form">
                <label>Email: </label><input type="text" name="email" placeholder="toto@gmail.com" required>
                <label>Password: </label><input type="password" name="password" required>
                <label>Password: (verification) </label><input type="password" name="password2" required>
                <button type="submit">Validate</button>
            </form>
            HTML;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $passwd = filter_var($_POST['password']);
            $passwd2 = filter_var($_POST['password2']);
            if($passwd != $passwd2){
                $html = "<p>Les 2 mdp ne sont pas identiques</p>";
            }
            else
            {
                try {
                    if (Auth::register($email, $passwd)) {
                        $token =  bin2hex(random_bytes(32));
                        $this->addToken($email, $token);
                        $activate_url = "?action=activation&token=$token";
                        $html = "<p>Click the link to activate your account : <a href=$activate_url>cliquez-ici</a></p>";
                    }
                    else {
                        $html = "<p>Email non valide</p>";
                    }
                } catch (EmailAlreadyRegistedException $e) {
                    $html = "<p>Cet email est déjà utilisé</p>";
                } catch (TooShortPasswordException $e) {
                    $html = "<p>Mot de passe trop court (10 caractères minimum)</p>";
                } catch (NotStrengthPassWord $e) {
                    $html = "<p>Mot de passe pas assez protégé</p>";
                }
            }
            $html .= "<br><a href='?action=add-user'>Retour</a>";
        }
        return $html;
    }

    /**
     * Ajoute un token dans la base de données d'une durée de 1 minute
     * @param string $email
     * @param string $token
     */
    public static function addToken($email, $token) : bool {
        $db = ConnectionFactory::makeConnection();
        $time = date('Y-m-d H:i:s', time() + 60);
        $query = $db->prepare('UPDATE User SET activation_token = ?, activation_expires = ? WHERE login = ?');
        $query->bindParam(1, $token);
        $query->bindParam(2, $time);
        $query->bindParam(3, $email);
        $query->execute();
        return $query->rowCount() == 1;
    }

}