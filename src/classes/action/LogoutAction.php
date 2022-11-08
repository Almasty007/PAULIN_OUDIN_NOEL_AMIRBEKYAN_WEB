<?php

namespace iutnc\sae\action;

class LogoutAction extends Action
{

    public function execute(): string
    {
        unset($_SESSION['user']);
        header("Location:index.php");
        return "";
    }
}