<?php

namespace SB\Bundle\CoreBundle\Utils;


class SBApp
{
    public function sanitizeValue($value)
    {
        // trim() supprime les espaces en début et en fin de chaîne
        // strip_tags() supprime les balises
        return trim(strip_tags($value));
    }
}