<?php

namespace Shokai\Controller;

use Shokai\Application;

abstract class AbstractController
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
}