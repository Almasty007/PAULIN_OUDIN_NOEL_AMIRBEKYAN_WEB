<?php

require_once "vendor/autoload.php";

use iutnc\deefy\db\ConnectionFactory;
use iutnc\deefy\dispatch\Dispatcher;
use iutnc\deefy\action\SigninAction;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddPodcastTrackAction;
use iutnc\deefy\action\DisplayPlaylistAction;

ConnectionFactory::setConfig("DBConfig.ini");
if (isset($_GET['action'])){
    $dispatcher = new Dispatcher();
    $dispatcher->run();
}
else {
    $action = <<<HTML
        <a href="?action=add-user">inscription</a><br>
        <a href="?action=signin">connection</a><br>
    HTML;
    echo $action;
}