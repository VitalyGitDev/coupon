<?php
namespace Api\Rest\V1\Controllers;

use Application\Core\ResourceController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Application\Core\Interfaces\VouchersAPIInterface;

class CouponsController extends ResourceController implements VouchersAPIInterface
{

    public function getDiscounts2() : JsonResponse
    {
        $sources = file_get_contents($this->services->get('appConfig')->get('global_coupons_t2'));
        $sources = json_decode($sources, true);
        return new JsonResponse($sources, 200);
    }

    /**
     * @inheritdock.
     */
    public function getDiscounts() : JsonResponse
    {
        $sources = file_get_contents($this->services->get('appConfig')->get('global_coupons_t1'));
        $sources = json_decode($sources, true);
        return new JsonResponse($sources, 200);
    }

}
