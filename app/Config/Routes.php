<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\{Home,Employee};

/**
 * @var RouteCollection $routes
 */

$routes->addRedirect('/','/hierarchy',302);
$routes->group('hierarchy',static function($routes){
    $routes->get('/',[Home::class,'hierarchy']);
    $routes->get('add/(:segment)',[Home::class,'addHierarchy']);
    $routes->get('edit/(:segment)',[Home::class,'editHierarchy']);
    $routes->delete('delete/(:any)',[Employee::class,'deleteEmployee']);
});
$routes->group('employee',static function($routes){
    $routes->post('add',[Employee::class,'storeEmployee'],['as'=>'add-employee']);
    $routes->post('update/(:any)',[Employee::class,'updateEmployee'],['as'=>'update-employee']);
});
