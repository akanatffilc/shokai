<?php

namespace Shokai\Routing\Generator;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGenerator as BaseUrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class UrlGenerator extends BaseUrlGenerator
{
    /** @var  Session|null */
    private $session;

    public function __construct(RouteCollection $routes, RequestContext $context, $logger, Session $session = null)
    {
        $this->session = $session;
        parent::__construct($routes, $context, $logger);
    }
}