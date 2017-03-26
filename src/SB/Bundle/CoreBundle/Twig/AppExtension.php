<?php

namespace SB\Bundle\CoreBundle\Twig;


class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('isSecure', array($this, 'isSecureFilter'), array(
                'is_safe' => array('html')
            )),
        );
    }

    public function isSecureFilter($message)
    {
        return nl2br($message);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'SBExtension';
    }
}