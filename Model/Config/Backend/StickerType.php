<?php

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
