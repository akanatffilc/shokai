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

    protected function doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, array $requiredSchemes = array())
    {
        $this->fillApplicationCategoryCode($parameters, $defaults, $requirements);
        return parent::doGenerate($variables, $defaults, $requirements, $tokens, $parameters, $name, $referenceType, $hostTokens, $requiredSchemes);
    }

    private function fillApplicationCategoryCode(&$parameters, $defaults, $requirements) {

        $name = 'acCode';

        if (!isset($requirements[$name])) {
            return;
        }

        if (isset($parameters[$name])) {
            return;
        }

        if (isset($defaults[$name]) && !empty($defaults[$name])) {

            $parameters[$name] = $defaults[$name];
            return;
        }

        if ($this->session && $this->session->has('applicationCategoryCode')) {
            $parameters[$name] = $this->session->get('applicationCategoryCode');
            return;
        }
    }

}