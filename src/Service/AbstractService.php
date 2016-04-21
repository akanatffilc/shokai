<?php

namespace Shokai\Service;

use Shokai\Application;

abstract class AbstractService
{
    protected $app;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    public function init() 
    {
        
    }
}
