<?php

namespace Shokai\Twig\Extension;

use Twig_Extension;


class CommonExtension extends Twig_Extension
{
   /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'shokai';
    }
}
