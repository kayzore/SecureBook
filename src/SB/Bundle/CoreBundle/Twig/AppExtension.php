<?php

namespace SB\Bundle\CoreBundle\Twig;


class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            'isSecure' => new \Twig_Filter_Method($this, 'isSecureFilter',
                array('is_safe' => array('html'))
            ),
        );
    }

    public function isSecureFilter($message)
    {
        return nl2br($message);
    }
}