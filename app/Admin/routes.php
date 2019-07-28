<?php

use App\Admin\Controllers\DoctorController;
use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->post('/', 'ReservationController@store')->name('admin.home.reservation.store');
    $router->get('/scheduling/table' , 'SchedulingController@table')->name('admin.scheduling.table');

    $router->post('/api/scheduling' , 'SchedulingController@apiStore')->name('admin.api.scheduling.store');

    $router->resource('doctors', 'DoctorController');
    $router->resource('reservations', 'ReservationController');
    $router->resource('scheduling-status', 'SchedulingStatusController');
    $router->resource('scheduling', 'SchedulingController');
    $router->resource('projects', 'ProjectController');
});
