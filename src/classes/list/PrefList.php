<?php

namespace iutnc\sae\list;

use iutnc\sae\media\Episode;

class PrefList
{
    protected [] $seriePref;
    public function __construct()
    {
        $episodePref = [];
    }

    function ajoutPref(Serie $s){
        $this->seriePref[] = $s;
    }

    function  supprimerPref(Serie $s){
        foreach ($this->seriePref as $index => $item) {
            if($s->equals($item)){
                unset($this->seriePref[$index]);
            }
        }
    }
}