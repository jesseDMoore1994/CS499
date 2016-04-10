<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('DashedRoute');

Router::scope('/', function ($routes) {

	$routes->connect('/', ['controller' => 'Home', 'action' => 'index']);
	$routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

	$routes->connect('/admin', ['controller' => 'TicketAdmin', 'action' => 'index']);

	$routes->connect('/admin/tickets', ['controller' => 'TicketAdmin', 'action' => 'index']);
	$routes->connect('/admin/tickets/*', ['controller' => 'TicketAdmin']);
	$routes->connect('/admin/tickets/api_manage/', ['controller' => 'TicketAdmin', 'action' => 'apiManage']);
	$routes->connect('/admin/tickets/api_manage/*', ['controller' => 'TicketAdmin', 'action' => 'apiManage']);

	$routes->connect('/admin/customers', ['controller' => 'CustomerAdmin', 'action' => 'index']);
	$routes->connect('/admin/customers/*', ['controller' => 'CustomerAdmin']);
	$routes->connect('/admin/customers/api_manage/', ['controller' => 'CustomerAdmin', 'action' => 'apiManage']);
	$routes->connect('/admin/customers/api_manage/*', ['controller' => 'CustomerAdmin', 'action' => 'apiManage']);

	$routes->connect('/admin/schedule', ['controller' => 'ScheduleAdmin', 'action' => 'index']);
	$routes->connect('/admin/schedule/*', ['controller' => 'ScheduleAdmin']);
	$routes->connect('/admin/schedule/api_manage/', ['controller' => 'ScheduleAdmin', 'action' => 'apiManage']);
	$routes->connect('/admin/schedule/api_manage/*', ['controller' => 'ScheduleAdmin', 'action' => 'apiManage']);

	$routes->connect('/admin/setup', ['controller' => 'SetupAdmin', 'action' => 'index']);

	$routes->connect('/admin/setup/seats/', ['controller' => 'SetupAdmin', 'action' => 'seats']);
	$routes->connect('/admin/setup/seats/*', ['controller' => 'SetupAdmin', 'action' => 'seats']);
	$routes->connect('/admin/setup/availability/', ['controller' => 'SetupAdmin', 'action' => 'availability']);
	$routes->connect('/admin/setup/availability/*', ['controller' => 'SetupAdmin', 'action' => 'availability']);
	$routes->connect('/admin/setup/staff/', ['controller' => 'SetupAdmin', 'action' => 'staff']);
	$routes->connect('/admin/setup/staff/*', ['controller' => 'SetupAdmin', 'action' => 'staff']);
	$routes->connect('/admin/setup/seasons/', ['controller' => 'SetupAdmin', 'action' => 'seasons']);
	$routes->connect('/admin/setup/seasons/*', ['controller' => 'SetupAdmin', 'action' => 'seasons']);

	$routes->connect('/admin/setup/api_season_manage/', ['controller' => 'SetupAdmin', 'action' => 'apiSeasonManage']);
	$routes->connect('/admin/setup/api_season_manage/*', ['controller' => 'SetupAdmin', 'action' => 'apiSeasonManage']);

	$routes->connect('/admin/settings/select/*', ['controller' => 'AdminSettings', 'action' => 'select']);

    $routes->connect('/admindata', ['controller' => 'AdminData', 'action' => 'index']);
    //$routes->connect('/admindata/*', ['controller' => 'AdminData']);
	/**
	 * Connect catchall routes for all controllers.
	 *
	 * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
	 *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
	 *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
	 *
	 * Any route class can be used with this method, such as:
	 * - DashedRoute
	 * - InflectedRoute
	 * - Route
	 * - Or your own route class
	 *
	 * You can remove these routes once you've connected the
	 * routes you want in your application.
	 */
	$routes->fallbacks('DashedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
