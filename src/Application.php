<?php

namespace Shokai;

use Silex\Application as SilexApp;

class Application extends SilexApp
{
    use \Silex\Application\TwigTrait;
    use \Silex\Application\MonologTrait;
    use \Silex\Application\UrlGeneratorTrait;
}


