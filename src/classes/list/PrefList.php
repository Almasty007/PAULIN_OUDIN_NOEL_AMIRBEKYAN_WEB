<?php

namespace iutnc\sae\list;

class PrefList
{
    protected [] $episodePref;
    public function __construct()
    {
        $episodePref = [];
    }

    function ajoutPref(Episode $e){
        unset($this->episodePref[$e]);
    }

    function  supprimerPref(Episode $e){

    }
}