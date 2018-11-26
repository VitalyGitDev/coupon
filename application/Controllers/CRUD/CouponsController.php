<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 24.11.18
 * Time: 23:08
 */
namespace Application\Controllers\CRUD;

use Application\Core\ResourceController;
use Application\Models\CouponModel;
use Application\Services\DataFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;

class CouponsController extends ResourceController
{
    protected $modelClass = CouponModel::class;

    /**
     * @inheritdoc.
     */
    public function index() : JsonResponse
    {
        return new JsonResponse(
            $this->modelClass::where(['checked_at' => null])->get(),
            200
        );
    }

    /**
     * Marks voucher as used.
     *
     * @param $params
     * @return JsonResponse
     * @throws \Exception
     */
    public function markDiscount($params) : JsonResponse
    {
        $couponId = $params['couponId'];
        /** @var CouponModel $coupon */
        $coupon = $this->modelClass::findOrFail($couponId);
        if ($coupon) {
            $coupon->fill([
                'checked_at' => (new \DateTime())->format('Y-m-d H:i:s')
            ]);
            $coupon->save();
        }
        return new JsonResponse([], 200);
    }

    /**
     * Requests data from remove storage via API call.
     *
     * @return JsonResponse
     */
    public function requestFromRepo($params) : JsonResponse
    {
        /** @var DataFetcher $fetcher */
        $fetcher = $this->services->get('dataFetcher');
        try {
            $fetcher->fetch('attempt_' . $params['times']);
            if (!empty($fetcher->data)) {
                $res = CouponModel::updateLocalStorage($fetcher->data, $this->services);
                return new JsonResponse([
                    'message' => "Created: " . $res['created'] . "  Updated: " . $res['updated']
                ], 200);

            } else
                return new JsonResponse(['message' => 'No data fetched!'], 417);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => 'An Error occurs during data fetching: ' . $e->getMessage()], 500);
        }
    }
}