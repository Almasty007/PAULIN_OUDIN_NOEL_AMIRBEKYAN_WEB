<?php

namespace iutnc\sae\media;

use iutnc\sae\media\Image;

class Episode extends Media
{
    private string $resume;
    private string $duree;
    private int $numero;

    public function __construct(Image $image, string $titre, string $resume, string $duree)
    {
        parent::__construct($image, $titre);
        $this->resume = $resume;
        $this->duree = $duree;
    }

    public function equals(Episode $episode): bool
    {
        $res = false;
        if ($episode->duree === $this->duree & $episode->titre === $this->titre & $episode->image === $this->image & $episode->resume === $this->resume) {
            $res = true;
        }
        return $res;
    }

    /**
     * @return Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }

    /**
     * @param Image $image
     */
    public function setImage(Image $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getTitre(): string
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getResume(): string
    {
        return $this->resume;
    }

    /**
     * @param string $resume
     */
    public function setResume(string $resume): void
    {
        $this->resume = $resume;
    }

    /**
     * @return string
     */
    public function getDuree(): string
    {
        return $this->duree;
    }

    /**
     * @param string $duree
     */
    public function setDuree(string $duree): void
    {
        $this->duree = $duree;
    }

    /**
     * @return int
     */
    public function getNumero(): int
    {
        return $this->numero;
    }

    /**
     * @param int $numero
     */
    public function setNumero(int $numero): void
    {
        $this->numero = $numero;
    }


}