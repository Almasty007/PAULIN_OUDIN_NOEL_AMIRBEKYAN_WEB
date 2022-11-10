<?php

namespace iutnc\sae\action;

use iutnc\sae\auth\Auth;

class SigninAction extends Action {

    public function execute() : string {
        $html = "";
        if($_SERVER['REQUEST_METHOD'] === "GET") {
            $html = <<<HTML
            <div class="div-form-log">
                <form action="?action=${_GET['action']}" method="post" class="log-form">
                    <label>Email: </label><input type="text" name="email" placeholder="toto@gmail.com" required>
                    <label>Password: </label><input type="password" name="password" required>
                    <button type="submit">Validate</button>
                </form>
            </div>
            HTML;
        }
        elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $passwd = filter_var($_POST['password']);
            if (Auth::isActivate($email)) {
                if (Auth::authenticate($email, $passwd)) {
                    $html = "<p>You are connected</p>";
                    header("Location:index.php");
                } else {
                    $html = "<p>Email or password incorrect</p>";
                }
            }
            else {
                $html = "<p>Veuillez activer votre compte</p>";
                $token =  bin2hex(random_bytes(32));
                AddUserAction::addToken($email, $token);
                $activate_url = "?action=activation&token=$token";
                $html.= "<p>Cliquez sur le lien pour activer votre compte : <a href=$activate_url>cliquez-ici</a></p>";
            }
        }
        return $html;
    }
}