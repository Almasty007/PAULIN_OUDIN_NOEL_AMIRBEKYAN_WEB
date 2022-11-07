<?php

require_once "vendor/autoload.php";
use iutnc\sae\classes\list\PrefList;

session_start();

if(!isset($_SESSION['prefList'])){
    $_SESSION['prefList'] = new PrefList();
}
