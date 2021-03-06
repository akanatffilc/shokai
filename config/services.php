<?php

use Shokai\Service\Provider\ShokaiUrlGeneratorServiceProvider;
use Shokai\Service\Provider\ShokaiTwigServiceProvider;
use Shokai\Service\Provider\ShokaiSessionServiceProvider;
use Shokai\Service\Provider\ShokaiDoctrineServiceProvider;
use Shokai\Service\Provider\ShokaiMonologServiceProvider;
use Shokai\Service\Provider\ShokaiEventSubscriberProvider;
use Shokai\Service\Provider\FacebookOAuthServiceProvider;
use Shokai\Service\Provider\AuthServiceProvider;
use Shokai\Service\Provider\UserServiceProvider;
use Shokai\Service\Provider\UserFbProfileServiceProvider;
use Shokai\Service\Provider\FriendsListServiceProvider;


$app->register(new ShokaiUrlGeneratorServiceProvider());
$app->register(new ShokaiTwigServiceProvider());
$app->register(new ShokaiSessionServiceProvider());
$app->register(new ShokaiDoctrineServiceProvider());
$app->register(new ShokaiMonologServiceProvider());
$app->register(new ShokaiEventSubscriberProvider());

$app->register(new FacebookOAuthServiceProvider());
$app->register(new AuthServiceProvider());
$app->register(new UserServiceProvider());
$app->register(new UserFbProfileServiceProvider());
$app->register(new FriendsListServiceProvider());