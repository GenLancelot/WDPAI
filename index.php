<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'],"/");
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('chat', 'SecurityController');
Routing::get('settings', 'DefaultController');
Routing::post('games', 'GamesController');
Routing::post('search', 'GamesController');
Routing::post('getgameranks', 'GamesController');
Routing::post('login', 'SecurityController');
Routing::post('registration', 'SecurityController');
Routing::post('settings_edit', 'SettingsController');
Routing::post('gameselection', 'SecurityController');
Routing::post('getusergames', 'SecurityController');
Routing::post('getnotusergames', 'SecurityController');
Routing::post('addNewUserGame', 'SecurityController');
Routing::post('retrieveNewUserData', 'SecurityController');
Routing::run($path);
