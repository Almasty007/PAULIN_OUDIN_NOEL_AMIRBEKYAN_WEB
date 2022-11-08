<?php

namespace iutnc\sae\render;

use iutnc\sae\media\Media;

interface Render
{


    function render (Media $media):void;
}