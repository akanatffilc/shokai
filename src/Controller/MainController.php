<?php

namespace Shokai\Controller;

use Shokai\Application;
use Shokai\Controller\AbstractController;
use Shokai\Facebook\FacebookQueryBuilder;

class MainController extends AbstractController
{
    public function __construct(Application $app) 
    {
        parent::__construct($app);
    }
    
    public function indexAction()
    {
        $fqb = FacebookQueryBuilder::getInstance($this->app);
        $request = $fqb->node('me')->accessToken($this->app->getToken());
        //$request->asEndpoint();
        //$response = file_get_contents((string) $request);
        var_dump($request);
        return $this->app->render('main/index.html.twig', [
            'message' => 'top mofo'
        ]);
    }
}

