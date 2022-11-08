<?php

namespace iutnc\sae\media;

abstract class Media
{
    protected Image $image;
    protected string $titre;

    public function __construct(Image $image, string $titre)
    {
        $this->image = $image;
        $this->titre = $titre;
    }
}