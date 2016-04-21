<?php

namespace Shokai\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFunction;
use Shokai\Application;

class CommonExtension extends Twig_Extension
{
    private $app;

    private $options;

    function __construct(Application $app, array $options = []) {
        $this->app = $app;
        $this->options = $options;
    }

    public function getFunctions() {
        return [
            'path'  => new Twig_SimpleFunction('path', [$this, 'path']),
        ];
    }
   /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'shokai';
    }

    public function path($route, array $parameters = array())
    {
        return $this->app->path($route, $parameters);
    }
}
