<?php

namespace iutnc\sae\action;

use iutnc\sae\auth\Auth;
use iutnc\sae\exception\EmailAlreadyRegistedException;
use iutnc\sae\exception\NotStrengthPassWord;
use iutnc\sae\exception\TooShortPasswordException;

class AddUserAction extends Action {

    public function execute() : string {
        $html = "";
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $html = <<<HTML
            <form action="?action=${_GET['action']}" method="post">
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
                $html = "les 2 mdp ne sont pas identiques";
            }
            else
            {
                try {
                    if (Auth::register($email, $passwd)) $html = "succesfully registered";
                    else $html = "email already exist";
                    $html .= "<br><a href='?action=signin'>Connection</a>";
                } catch (EmailAlreadyRegistedException $e) {
                    $html = "email has already registed";
                    $html .= "<br><a href='?action=add-user'>Retour</a>";
                } catch (TooShortPasswordException $e) {
                    $html = "password too short";
                    $html .= "<br><a href='?action=add-user'>Retour</a>";
                } catch (NotStrengthPassWord $e) {
                    $html = "mot de passe n'est pas assez protege";
                    $html .= "<br><a href='?action=add-user'>Retour</a>";
                }
            }

        }
        return $html;
    }
}