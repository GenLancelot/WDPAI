<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'],"/");
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('profile', 'DefaultController');
Routing::get('main', 'DefaultController');
Routing::get('chat', 'DefaultController');
Routing::get('settings', 'SettingsController');

Routing::post('admin', 'GamesController');
Routing::post('search', 'GamesController');
Routing::post('getgameranks', 'GamesController');
Routing::post('adminupload', 'GamesController');
Routing::post('getnextuser', 'SecurityController');
Routing::post('login', 'SecurityController');
Routing::post('logout', 'SecurityController');
Routing::post('registration', 'SecurityController');
Routing::post('gameselection', 'SecurityController');
Routing::post('getusergames', 'SecurityController');
Routing::post('getnotusergames', 'SecurityController');
Routing::post('addNewUserGame', 'SecurityController');
Routing::post('retrieveNewUserData', 'SecurityController');
Routing::post('games', 'GamesController');
Routing::post('settings_edit', 'SettingsController');
Routing::post('settings_file_edit', 'SettingsController');
Routing::run($path);
