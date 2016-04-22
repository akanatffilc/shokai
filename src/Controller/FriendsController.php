<?php

namespace Shokai\Controller;

use Shokai\Controller\AbstractController;
use Shokai\Service\FacebookQueryBuilderService;

class FriendsController extends AbstractController 
{
    public function __construct(Application $app) 
    {
        parent::__construct($app);
    }
    
    public function listAction()
    {
        $fqb = new FacebookQueryBuilderService($this->app);
        $request = $fqb->node('me')->fields(['id', 'email']);
        $response = file_get_contents((string) $request);
        var_dump($response);
        return $this->app->render('main/index.html.twig');
    }
}



