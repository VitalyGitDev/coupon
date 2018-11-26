<?php
namespace Application\Models;

use Application\Core\Model;
use Application\Core\ServiceLocator;

class CouponModel extends Model
{
    /**
     * @inheritdoc.
     */
    protected $table = "vouchers";

    /**
     * @inheritdoc.
     */
    protected $fillable = [
        'code',
        'program_id',
        'partner_voucher_id',
        'start_date',
        'expiry_date',
        'discount',
        'description',
        'destination_url',
        'currency_id',
        'commission_value_formatted',
        'commission_value',
        'checked_at',
    ];

    /**
     * @inheritdoc.
     */
    protected $with = [ 'program', 'currency' ];

    /**
     * Method requests data from remote repository via API.
     * API repository(ies) must be configured in dataFetcher config file.
     *
     * @param array $data
     * @param ServiceLocator $services
     * @return array
     */
    public static function updateLocalStorage(array $data, ServiceLocator $services) : array
    {
        $result = ['updated' => 0, 'created' => 0];
        foreach($data as $item) {
            $mapped = $services->get('dataMapper')->map($item, 'coupon');
            /** @var CouponModel $existedCoupon */
            $existedCoupon = static::where(['partner_voucher_id' => $mapped['partner_voucher_id']])->first();
            if (empty($existedCoupon))
                $result['created'] += (int) static::createNew($mapped);
            else
                $result['updated'] += (int) $existedCoupon->review($mapped);
        }
        return $result;
    }

    /**
     * Creates new Coupon and saves it to our DB.
     *
     * @param $data
     * @return int
     */
    protected static function createNew($data) : int
    {
        $newEntity = new static($data);
        return (int) $newEntity->save();
    }

    /**
     * Updates Coupon if any field data is different in inbound data group.
     *
     * @param $data
     * @return int
     */
    public function review($data) : int
    {
        $forUpdate = false;
        foreach($data as $key => $val) {
            if ($this->$key != $val)
                $forUpdate = true;
        }

        if ($forUpdate) {
            $this->fill(array_merge($data, ['checked_at' => null]));
            return (int) $this->save();
        }
        return (int) false;
    }

    /**
     * Returns Program instance for current Coupon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program()
    {
        return $this->belongsTo(ProgramModel::class);
    }

    /**
     * Returns Currency instance for current Coupon.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(CurrencyModel::class);
    }
}
