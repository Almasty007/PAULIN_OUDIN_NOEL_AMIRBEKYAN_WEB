<?php

namespace iutnc\sae\action;

class ModifProfilAction extends Action

{

    public function execute(): string
    {
        return "<form method='post' action='?action=profilmodif'>
                <input type='text' name='nom' placeholder='Nom'></input>
                <input type='text' name='prenom' placeholder='Prenom'></input>
                <input type='text' name='pseudo' placeholder='Pseudo'></input>
                <input type='date' name='date' placeholder='Date de Naissance'></input>
                <br>
                <button type='submit'>Valider</button>
                </form>";
    }
}