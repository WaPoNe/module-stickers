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

class StickerType implements ArrayInterface
{
    public function toOptionArray()
    {
        $stickerTypes = array();

        $stickerTypes[] = [
            'value' => 'image',
            'label' => __('Image')
        ];
        $stickerTypes[] = [
            'value' => 'custom',
            'label' => __('Custom Label')
        ];

        return $stickerTypes;
    }
}
