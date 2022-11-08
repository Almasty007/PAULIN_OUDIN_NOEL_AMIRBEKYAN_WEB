<?php

namespace iutnc\sae\list;

use iutnc\sae\media\Episode;

class PrefList
{

    protected $seriePref = array();

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

    function isIn(Serie $s):boolean{
        return array_key_exists($s, $this->seriePref);
    }

    /**
     * @return array
     */
    public function getSeriePref(): array
    {
        return $this->seriePref;
    }
}