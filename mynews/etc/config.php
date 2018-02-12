<?php
/**
 * Created by PhpStorm.
 * User: gendos
 * Date: 11/1/17
 * Time: 21:14
 */

use App\Core\Config;

/**
 * Routing
 */
Config::set('routes', ['default', 'admin']);
Config::set('defaultRoute', 'default');
Config::set('defaultController', 'Categories');
Config::set('defaultAction', 'index');

/**
 * Lang
 */
Config::set('languages', ['en', 'ru']);
Config::set('defaultLanguage', 'ru');

/**
 * Pagination
 */
Config::set('itemsPerPage', 5);

/**
 * Debug
 */
Config::set('debug', true);


/**
 * Meta
 */
Config::set('siteName', 'News Battlefield');


/**
 * Database
 */
Config::set('db.host', 'localhost:3306');
Config::set('db.user', 'root');
Config::set('db.password', '');
Config::set('db.name', 'mynews');

/**
 * json file with controller $data contents
 */
Config::set('json_path', ROOT . DS . 'public' . DS . 'json' . DS);

/**
 * User
 */
Config::set('sault', 'sdf703dfg884$hsd7dfdf4');
