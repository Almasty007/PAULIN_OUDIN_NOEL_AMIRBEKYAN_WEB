<?php

namespace iutnc\sae\action;

use iutnc\sae\auth\Auth;

class SigninAction extends Action {

    public function execute() : string {
        $html = "";
        if($_SERVER['REQUEST_METHOD'] === "GET") {
            $html = <<<HTML
                <form action="?action=${_GET['action']}" method="post">
                    <label>Email: </label><input type="text" name="email" placeholder="toto@gmail.com" required>
                    <label>Password: </label><input type="password" name="password" required>
                    <button type="submit">Validate</button>
                </form>
            HTML;
        }
        elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
            $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $passwd = filter_var($_POST['password']);
            if (Auth::authenticate($email, $passwd)) {
                $html = "<p>You are connected</p>";
                header("Location:index.php");
            } else {
                $html = "<p>email or password incorrect</p>";
            }
        }
        return $html;
    }
}