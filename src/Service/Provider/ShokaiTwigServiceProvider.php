<?php
    
namespace Shokai\Service\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\TwigServiceProvider;
use Shokai\Twig\Extension\CommonExtension;

/**
* @package Shokai\Service\Provider
*/
class ShokaiTwigServiceProvider extends TwigServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app->register(new TwigServiceProvider());
        $app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
            $twig->addExtension(new CommonExtension($app));
            $twig->addExtension(new \Twig_Extension_Debug());
            return $twig;
        }));
        $app['twig.path'] = TWIG_PATH;
        $app['twig.options'] = [
            'cache' => TWIG_OPTIONS
        ];
    }

    public function boot(Application $app)
    {

    }
}

