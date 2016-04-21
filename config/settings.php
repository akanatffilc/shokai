<?php

// Global settings
setlocale(LC_ALL, 'ja_JP.UTF-8');
mb_language('Japanese');
mb_internal_encoding('UTF-8');
date_default_timezone_set('Asia/Tokyo');
ini_set('html_errors', 'Off');

// Define
defined('APP_ROOT_DIR') or define('APP_ROOT_DIR', dirname(__DIR__));

/* ShokaiSessionServiceProvider */
defined('SESSION_STORAGE_OPTION_NAME') or define('SESSION_STORAGE_OPTION_NAME', "shokaisession");

/* ShokaiTwigServiceProvider */
defined('TWIG_PATH') or define('TWIG_PATH', realpath(__DIR__.'/../templates'));
defined('TWIG_OPTIONS') or define('TWIG_OPTIONS', realpath(__DIR__.'/../var/cache/twig'));

/* ShokaiDoctrineServiceProvider */
defined('DB_NAME') or define('DB_NAME', 'shokai');

/* ShokaiMonologServiceProvider */
defined('LOGGER_PATH') or define('LOGGER_PATH', APP_ROOT_DIR . "/logs/");
defined('LOGGER_FILE_NAME') or define('LOGGER_FILE_NAME', "error_%d.log");
defined('LOGGER_LEVEL') or define('LOGGER_LEVEL', \Monolog\Logger::NOTICE);

/* FacebookService */
defined('FACEBOOK_CLIENT_ID') or define('FACEBOOK_CLIENT_ID', '132789953788085');
defined('FACEBOOK_CLIENT_SECRET') or define('FACEBOOK_CLIENT_SECRET', 'a92612ca8a2d8141f8332f4431938194');
defined('FACEBOOK_GRAPH_API_VERSION') or define('FACEBOOK_GRAPH_API_VERSION', 'v2.6');
