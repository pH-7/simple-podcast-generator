<?php
defined('PUBLIC_ACCESS') or exit('Restricted Access');

$configFile = parse_ini_file(__DIR__ . '/config.ini', true);

define('ROOT_URL', $configFile['settings']['base.url']);
define('PODCAST_NAME', $configFile['settings']['podcast.name']);
define('PODCAST_DESCRIPTION', $configFile['settings']['podcast.description']);
