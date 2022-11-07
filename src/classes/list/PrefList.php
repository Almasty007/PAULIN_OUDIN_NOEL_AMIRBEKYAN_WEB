<?php

namespace iutnc\sae\list;

use iutnc\sae\media\Episode;

class PrefList
{
    protected [] $episodePref;
    public function __construct()
    {
        $episodePref = [];
    }

    function ajoutPref(Episode $e){
        $this->episodePref[] = $e;
    }

    function  supprimerPref(Episode $e){
        foreach ($this->episodePref as $index => $item) {
            if($e->equals($item)){
                unset($this->episodePref[$index]);
            }
        }
    }
}