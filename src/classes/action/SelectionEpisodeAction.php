<?php

namespace iutnc\sae\action;

use iutnc\sae\media\Episode;

class SelectionEpisodeAction extends Action{

    private string $id;

    public function __construct(string $id){
        parent::__construct();
        $this->id = $id;
    }

    public function execute(): string{
        return Episode::affichier($this->id);
    }
}