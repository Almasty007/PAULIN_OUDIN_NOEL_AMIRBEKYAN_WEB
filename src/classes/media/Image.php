<?php

namespace iutnc\sae\media;

class Image
{

    private string $path;

    public function __construct(String $path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }


}