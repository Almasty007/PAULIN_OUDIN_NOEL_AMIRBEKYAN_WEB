<?php

namespace iutnc\sae\media;
use iutnc\sae\media\Episode;

class Serie
{
    private $episodes = array();
    private Image $image;
    private string $titre;
    private int $nbrEpisode = 0;

    public function __construct(Image $image, string $titre)
    {
        $this->image = $image;
        $this->titre = $titre;
    }


    public function ajouterEpisode(Episode $episode){
        $this->episodes[] = $episode;
        $this->nbrEpisode++;
        $episode->setNumero($this->nbrEpisode);
    }

    public function equals(Serie $serie): bool
    {
        $res = false;
        if($serie->titre === $this->titre & $serie->image === $this->image){
            $res = true;
        }
        return $res;
    }

    /**
     * @return array
     */
    public function getEpisodes(): array
    {
        return $this->episodes;
    }

    /**
     * @return Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @return int
     */
    public function getNbrEpisode(): int
    {
        return $this->nbrEpisode;
    }
}