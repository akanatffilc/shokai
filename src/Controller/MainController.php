<?php

namespace Shokai\Controller;

use Shokai\Application;
use Shokai\Controller\AbstractController;

class MainController extends AbstractController
{
    public function __construct(Application $app) 
    {
        parent::__construct($app);
    }
    
    public function indexAction()
    {
        return $this->app->render('main/index.html.twig', [
            'message' => 'top mofo'
        ]);
    }
}

