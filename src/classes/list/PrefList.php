<?php

namespace iutnc\sae\list;

use iutnc\sae\media\Episode;

class PrefList
{

    protected [] $seriePref;

    public function __construct(){}

    function ajoutPref(Serie $s): void{
        $this->seriePref[] = $s;
    }

    function  supprimerPref(Serie $s): void{
        foreach ($this->seriePref as $index => $item) {
            if($s->equals($item)){
                unset($this->seriePref[$index]);
            }
        }
    }
}