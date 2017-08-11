<?php
/**
 * WaPoNe
 *
 * @category   WaPoNe
 * @package    WaPoNe_Stickers
 * @copyright  Copyright (c) 2017 WaPoNe (http://www.fantetti.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace WaPoNe\Stickers\Model\Config\Backend;

use Magento\Framework\Option\ArrayInterface;

class DiscountCalculationType implements ArrayInterface
{
    public function toOptionArray()
    {
        $calculationType = array();

        $calculationType[] = [
            'value' => 'manual',
            'label' => __('Manual')
        ];
        $calculationType[] = [
            'value' => 'automatic',
            'label' => __('Automatic')
        ];

        return $calculationType;
    }
}
