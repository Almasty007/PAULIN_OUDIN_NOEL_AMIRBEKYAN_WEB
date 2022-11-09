<?php

namespace iutnc\sae\action;

use iutnc\sae\media\Episode;

class SelectionEpisodeAction extends Action{

    private string $id_episode;
    private string $id_serie;

    public function __construct(string $id_serie,string $id_episode){
        parent::__construct();
        $this->id_episode = $id_episode;
        $this->id_serie = $id_serie;
    }

    public function execute(): string{
        return Episode::affichier($this->id_serie,$this->id_episode);
    }
}