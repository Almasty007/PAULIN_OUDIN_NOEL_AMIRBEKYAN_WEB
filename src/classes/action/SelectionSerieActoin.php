<?php

namespace iutnc\sae\action;

use iutnc\sae\media\Serie;

class SelectionSerieActoin extends Action{

    private string $id;

    public function __construct(string $id){
    parent::__construct();
    $this->id = $id;
    }

    public function execute(): string{
        return Serie::affichier($this->id);
    }
}