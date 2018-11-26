<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 24.11.18
 * Time: 16:38
 */

use Symfony\Component\Routing;
use Application\Controllers\FrontController;
use Application\Controllers\CRUD\CouponsController;
use Api\Rest\V1\Controllers\CouponsController as CouponsAPIController;

// Default Front routes.
$defaultRoutes = new Routing\RouteCollection();
$defaultRoutes->add('index_page', new Routing\Route('/', [
    '_controller' => FrontController::class . '::index',
]));

$defaultRoutes->add('coupons_list', new Routing\Route('/coupons', [
    '_controller' => CouponsController::class . '::index',
], [], [], '', [], ['GET']));

$defaultRoutes->add('coupon_check', new Routing\Route('/coupons/{couponId}/mark', [
    '_controller' => CouponsController::class . '::markDiscount',
], ['couponId' => '\d+'], [], '', [], ['GET']));

$defaultRoutes->add('coupons_from_repo', new Routing\Route('/coupons/request/{times}', [
    '_controller' => CouponsController::class . '::requestFromRepo',
], [], [], '', [], ['GET']));



// API Routes.
$APIRoutes = new Routing\RouteCollection();
$APIRoutes->add('coupons_index', new Routing\Route('/api/v1/coupons', [
    '_controller' => CouponsAPIController::class . '::getDiscounts',
], [], [], '', [], ['GET', 'HEAD']));

$APIRoutes->add('coupons_index_t2', new Routing\Route('/api/v1/coupons/t2', [
    '_controller' => CouponsAPIController::class . '::getDiscounts2',
], [], [], '', [], ['GET', 'HEAD']));


return [
    'default_routes' => $defaultRoutes,
    'api_routes' => $APIRoutes,
];
