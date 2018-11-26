<?php
/**
 * Created by PhpStorm.
 * User: navi
 * Date: 25.11.18
 * Time: 14:27
 */

namespace Application\Core\Interfaces;


interface VouchersAPIInterface
{
    /**
     * This method will return all vouchers from our partner
     * in a JSON format
     *
     * Our partner will deliver the result of
     * input1.json on the first call and
     * input2.json on all other calls
     *
     * @return string JSON formatted string
     */
    public function getDiscounts();
}