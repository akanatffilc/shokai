<?php

namespace Shokai\Controller;

use Shokai\Application;
use Shokai\Controller\AbstractController;

class MainController extends AbstractController implements LoginAuthenticatedController
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
    
    public function initSetupAction()
    {
        $user = $this->app->getUser();
        $this->app['service.profile.fb.user']->createUserFbProfile($user);
        $this->app['service.list.friends']->createFriendsList($user);
        return $this->redirectTop();
    }
}

